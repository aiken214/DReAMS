<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyNodRequest;
use App\Http\Requests\StoreNodRequest;
use App\Http\Requests\UpdateNodRequest;
use App\Models\Iar;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class NodController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('nod_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.nod.index');
    }

    public function getNods(Request $request)
    {            
                
        // Fetch data
        $data = Iar::with([
            'purchase_order:id,po_no,purchase_request_id',
            'purchase_order.purchase_request:id,office,purpose', 
            'supplier:id,name'])
            ->orderBy('id', 'asc')->get();

        // Use DataTables with the query
        return datatables($data)
            ->editColumn('date', function ($row) {
                return $row->nod_date. ' ' .$row->nod_time;
            })
            ->editColumn('reference', function ($row) {
                return $row->purchase_order?->po_no;
            })
            ->editColumn('supplier', function ($row) {
                return $row->supplier?->name;
            })
            ->editColumn('office', function ($row) {
                return $row->purchase_order?->purchase_request->office;
            })
            ->editColumn('purpose', function ($row) {
                return $row->purchase_order?->purchase_request->purpose;
            })
            ->rawColumns(['reference', 'supplier', 'office', 'purpose']) // Specify columns with raw HTML, if applicable
            ->make(true);   

    }

    public function edit($id)
    {
        abort_if(Gate::denies('iar_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $iar = Iar::select(['id', 'invoice_no', 'nod_date', 'nod_time'])->where('id', $id)->orderBy('id', 'asc')->first();

        return view('supply.nod.edit', compact('iar'));
    }

    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('iar_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $data = Iar::find($id);
		$nod_data = [
            'invoice_no' => $request->invoice_no,
            'nod_date' => $request->nod_date, 
            'nod_time' => $request->nod_time
        ];

		$data->update($nod_data);

        return redirect()->route('supply.nod.index');
    }

    public function show($id)
    {
        abort_if(Gate::denies('nod_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $iar = Iar::with([
            'purchase_order:id,po_no,purchase_request_id',
            'purchase_order.purchase_request:id,office,purpose', 
            'supplier:id,name'])
            ->where('id', $id)
            ->orderBy('id', 'asc')->first();

        return view('supply.nod.show', compact('iar'));
    }
}
