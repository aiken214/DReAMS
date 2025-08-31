<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequestItem;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PoItemCheckController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('purchase_order_item_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $id = $request->id;
        
        $data = PurchaseOrder::find($id);
        $amount =  DB::table('purchase_order_items')->where('purchase_order_id', $id)->sum('amount');  

        return view('supply.purchase_order_item_check.index', compact('id', 'data', 'amount'));
    }

    public function getPurchaseOrderItemChecks(Request $request)
    {
        $id = $request->get('purchase_order_id');
        $data = PurchaseOrderItem::with('purchase_order')->where('purchase_order_id', $id)->get();

        // Use DataTables with the query
        return datatables($data)
            ->editColumn('description', function ($row) {
                return '<span style="white-space:normal">' . e($row->description) . '</span>';
            })

            ->rawColumns(['description']) // Specify columns with raw HTML, if applicable
            ->make(true); 
    }

}
