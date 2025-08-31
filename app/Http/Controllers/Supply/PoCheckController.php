<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
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

class PoCheckController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('purchase_order_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.purchase_order_check.index');
    }

    public function getPurchaseOrderChecks(Request $request)
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
                return $row->supplier->name;
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

    public function show($id)
    {
        abort_if(Gate::denies('purchase_order_check_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseOrder = PurchaseOrder::with(['purchase_request:id,pr_no,purpose,fund_source'], ['supplier:id.name.address,tin'])
            ->where('id', $id)->first();

        return view('supply.purchase_order_check.show', compact('purchaseOrder'));
    }

}
