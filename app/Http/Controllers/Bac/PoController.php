<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPoRequest;
use App\Http\Requests\StorePoRequest;
use App\Http\Requests\UpdatePoRequest;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class PoController extends Controller
{
    use CsvImportTrait; 

    public function index()
    {
        abort_if(Gate::denies('purchase_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('bac.purchase_order.index');
    }

    public function getPurchaseOrders(Request $request)
    {            
        // Fetch data
        $data = PurchaseOrder::with(['purchase_request', 'supplier'])->orderByDesc('id');

        // Use DataTables with the query
        return datatables($data)
            ->editColumn('delivery', function ($row) { 
                $deliveryPlace = $row->delivery_place ?? 'No place specified';
                $deliveryDate = !empty($row->delivery_date) ? $row->delivery_date : 'On the Date';    
                $delivery = "Place: {$deliveryPlace} <br> Date: {$deliveryDate}"; 
        
                return $delivery;
            })
            ->editColumn('term', function($data) {  
                $deliveryTerm = $data->delivery_term ? $data->delivery_term . " days" : "No delivery term specified";
                $paymentTerm = $data->payment_term ?? "No payment term specified";
            
                $term = "Delivery: {$deliveryTerm}<br>Payment: {$paymentTerm}";
                return $term;
            })
            ->editColumn('supplier', function ($row) {
                return $row->supplier?->name;
            })
            ->editColumn('pr_no', function ($row) {
                return $row->purchase_request->pr_no;
            })
            ->editColumn('purpose', function ($row) {
                return '<span style="white-space:normal">' . e($row->purchase_request->purpose) . '</span>';
            })
            ->editColumn('fund_source', function ($row) {
                return '<span style="white-space:normal">' . e($row->purchase_request->fund_source) . '</span>';
            })
            ->rawColumns(['delivery', 'term', 'supplier', 'pr_no', 'purpose', 'fund_source']) // Specify columns with raw HTML, if applicable
            ->make(true); 

    }    

    public function create()
    {
        abort_if(Gate::denies('purchase_order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseRequests = PurchaseRequest::join('purchase_request_items', 'purchase_requests.id', '=', 'purchase_request_items.purchase_request_id')
            ->whereNull('purchase_requests.deleted_at')
            ->whereNull('purchase_request_items.purchase_order_item_id')
            ->select(
                'purchase_requests.id',
                'purchase_requests.pr_no',
                DB::raw('SUM(purchase_request_items.quantity) as total_quantity')
            )
            ->groupBy('purchase_requests.id', 'purchase_requests.pr_no')
            ->having('total_quantity', '!=', 0) // Ensures only rows with a non-zero sum are included
            ->orderBy('purchase_requests.pr_no', 'desc')
            ->get();

        $suppliers = Supplier::all()->sortBy('name');

        return view('bac.purchase_order.create', compact('purchaseRequests', 'suppliers'));
    }

    public function store(StorePoRequest $request)
    {
        abort_if(Gate::denies('purchase_order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = Carbon::now();
        $data = $request->all();
        $data['po_no'] =  $this->generatePoNo();

        $purchaseOrder = PurchaseOrder::create($data);

        $purchaseRequests = PurchaseRequest::findOrfail($request->purchase_request_id); 
            $purchaseRequests->remarks = 'PO prepared by BAC';
            $purchaseRequests->served = $date; 
        $purchaseRequests->save();

        return redirect()->route('bac.purchase_order.index');
    }

    private function generatePoNo()
    {
        $last_po = PurchaseOrder::where('po_no', 'like', 'PO%')->orderByDesc('po_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'PO';

        if (!$last_po || !$last_po->po_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_po->po_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        abort_if(Gate::denies('purchase_order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $purchaseOrder->load(['supplier:id,name']);
        $suppliers = Supplier::all()->sortBy('name');

        return view('bac.purchase_order.edit', compact('purchaseOrder', 'suppliers'));
    }

    public function update(UpdatePoRequest $request, PurchaseOrder $purchaseOrder)
    {
        abort_if(Gate::denies('purchase_order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $purchaseOrder->update($request->all());

        return redirect()->route('bac.purchase_order.index');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        abort_if(Gate::denies('purchase_order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseOrder->load(['purchase_request:id,pr_no,purpose,fund_source'], ['supplier:id,name,address,tin']);

        return view('bac.purchase_order.show', compact('purchaseOrder'));
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        abort_if(Gate::denies('purchase_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseOrder->delete();

        return back();
    }

    public function massDestroy(MassDestroyPoRequest $request)
    {
        abort_if(Gate::denies('purchase_order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        PurchaseOrder::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
