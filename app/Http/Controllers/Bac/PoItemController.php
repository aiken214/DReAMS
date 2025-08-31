<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPoItemRequest;
use App\Http\Requests\StorePoItemRequest;
use App\Http\Requests\UpdatePoItemRequest;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequestItem;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PoItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('purchase_order_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $id = $request->id;        
        $data = PurchaseOrder::find($id);        
        $amount =  DB::table('purchase_order_items')->where('purchase_order_id', $id)->sum('amount');  

        return view('bac.purchase_order_item.index', compact('id', 'data', 'amount'));
    }

    public function getPurchaseOrderItems(Request $request)
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

    public function create(Request $request)
    {
        abort_if(Gate::denies('purchase_order_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;
        $purchase_request_id = PurchaseOrder::find($id)->purchase_request_id;
        $items = PurchaseRequestItem::where('purchase_request_id', $purchase_request_id)->whereNull('purchase_order_item_id')->get();
       
        return view('bac.purchase_order_item.create', compact('id', 'items'));
    }

    public function store(StorePoItemRequest $request)
    {
        $data = $request->all();
        $id = $request->purchase_order_id;

        $purchaseOrderItem = PurchaseOrderItem::create($data);
        $purchaseRequestItem = PurchaseRequestItem::find($request->purchase_request_item_id);
            if ($purchaseRequestItem) {
                $purchaseRequestItem->purchase_order_item_id = $purchaseOrderItem->id; // Assign new value
                $purchaseRequestItem->save(); // Save the changes
            } else {
                return response()->json(['message' => 'Purchase Request Item not found'], 404);
            }

        return redirect()->route('bac.purchase_order_item.index', compact('id'));
    }

    public function edit(PurchaseOrderItem $purchaseOrderItem)
    {
        abort_if(Gate::denies('purchase_order_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('bac.purchase_order_item.edit', compact('purchaseOrderItem'));
    }

    public function update(UpdatePoItemRequest $request, PurchaseOrderItem $purchaseOrderItem)
    {
        $purchaseOrderItem->update($request->all());
        $id = $request->purchase_order_id;

        return redirect()->route('bac.purchase_order_item.index', compact('id'));
    }

    public function show(PurchaseOrderItem $purchaseOrderItem)
    {
        abort_if(Gate::denies('purchase_order_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('bac.purchase_order_item.show', compact('purchaseOrderItem'));
    }

    public function destroy(PurchaseOrderItem $purchaseOrderItem)
    {
        abort_if(Gate::denies('purchase_order_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseOrderItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyPoItemRequest $request)
    {
        PurchaseOrderItem::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
