<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIarRequest;
use App\Http\Requests\StoreIarRequest;
use App\Http\Requests\UpdateIarRequest;
use App\Models\Iar;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class IarController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('iar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.iar.index');
    }

    public function getIars(Request $request)
    {            
                
        // Fetch data
        $data = Iar::with([
            'purchase_request:id,pr_no,office',
            'purchase_order:id,po_no,purchase_request_id',
            'purchase_order.purchase_request:id,office', 
            'supplier:id,name'])
            ->orderBy('id', 'asc')->get();

        // Use DataTables with the query
        return datatables($data)
            ->editColumn('reference', function ($row) {
                return $row->purchase_order?->po_no ?? $row->purchase_request?->pr_no ?? '';
            })
            ->editColumn('supplier', function ($row) {
                return $row->supplier?->name;
            })
            ->editColumn('office', function ($row) {
                // return $row->purchase_order?->purchase_request->office ?? $row->purchase_request?->office ?? '';
                return $row->purchase_request?->office ?? '';
            })
            ->rawColumns(['reference', 'supplier', 'office']) // Specify columns with raw HTML, if applicable
            ->make(true);   

    }

    public function create()
    {
        abort_if(Gate::denies('iar_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseOrders = PurchaseOrder::with(['purchase_order_item' => function ($query) {
            $query->whereNull('status')
                  ->orWhere('status', '!=', 'Complete');
            }])
            ->whereHas('purchase_order_item', function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'Complete');
            })
            ->get();

        return view('supply.iar.create', compact('purchaseOrders'));
    }

    public function store(StoreIarRequest $request)
    {
        $date = Carbon::now();
        $data = $request->all();
        $data['iar_no'] =  $this->generateIarNo();
       
        $iar = Iar::create($data); 

        $purchaseOrders = PurchaseOrder::findOrfail($request->purchase_order_id); 
        $purchaseRequests = PurchaseRequest::findOrfail($purchaseOrders->purchase_request_id); 
            $purchaseRequests->remarks = 'Item/s delivered by the supplier';
            $purchaseRequests->delivered = $date; 
        $purchaseRequests->save();

        return redirect()->route('supply.iar.index');
    }

    public function createFromPettyCash()
    {
        abort_if(Gate::denies('iar_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseRequests = PurchaseRequest::where('fund_source', 'like', '%Petty Cash%')
            ->whereNotNull('approved')
            ->whereNull('petty_cash_iar_id')
            ->get();
    
        $suppliers = Supplier::all()->sortBy('name');    

        return view('supply.iar.create_from_petty_cash', compact('purchaseRequests', 'suppliers'));
    }

    public function storeFromPettyCash(StoreIarRequest $request)
    {
        $data = $request->all();
        $data['iar_no'] =  $this->generateIarNo();

        $iar = Iar::create($data);
        $iar_id = $iar->id;
        PurchaseRequest::where('id', $request->purchase_requuest_id)->update(['petty_cash_iar_id' => $iar_id]); 

        return redirect()->route('supply.iar.index');
    }

    private function generateIarNo()
    {
        $last_iar = Iar::where('iar_no', 'like', 'IAR%')->orderByDesc('iar_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'IAR';

        if (!$last_iar || !$last_iar->iar_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_iar->iar_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }    

    public function edit(Iar $iar)
    {
        abort_if(Gate::denies('iar_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $iar->load(['supplier:id,name']);

        return view('supply.iar.edit', compact('iar'));
    }

    public function update(UpdateIarRequest $request, Iar $iar)
    {
        $iar->update($request->all());

        return redirect()->route('supply.iar.index');
    }

    public function show(Iar $iar)
    {
        abort_if(Gate::denies('iar_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $iar->load([
            'purchase_order.purchase_request:id,office', 
            'supplier:id,name,address,tin'
        ]);

        return view('supply.iar.show', compact('iar'));
    }

    public function destroy(Iar $iar)
    {
        abort_if(Gate::denies('iar_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        PurchaseOrder::where('id', $iar->purchase_order_id)->update(['status' => null]);

        $iar->delete();

        return back();
    }
}
