<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPrItemRequest;
use App\Http\Requests\StorePrItemRequest;
use App\Http\Requests\UpdatePrItemRequest;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Ppmp;
use App\Models\PpmpItem;
use App\Models\User;
use App\Models\ItemsList;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrItemController extends Controller
{
    
    public function index(Request $request)
    {
        abort_if(Gate::denies('purchase_request_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $id = $request->id;
        $data = PurchaseRequest::find($id);
        $total_cost =  DB::table('purchase_request_items')->where('purchase_request_id', $id)->sum('total_cost');  

        return view('user.purchase_request_item.index', compact('id', 'data', 'total_cost'));
    }

    public function getPurchaseRequestItems(Request $request)
    {
        $id = $request->get('purchase_request_id');
        $data = PurchaseRequestItem::with('purchase_request')->where('purchase_request_id', $id)->get();

        return datatables($data)->make(true);  
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('purchase_request_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;
        $units = Unit::all()->sortBy('unit');
        $user_id = Auth::user()->id;
        $station_id = User::where('id', $user_id)->first()->station_id; 
        $ppmp_id = PurchaseRequest::where('id', $id)->first()->ppmp_id; 
        $items = Ppmp::join('ppmp_items', 'ppmps.id', '=', 'ppmp_items.ppmp_id') // Join based on ppmp_id in ppmp_items table
            ->with('ppmp_item') // Ensure the relationship is still eager loaded
            ->where('ppmp_id', $ppmp_id)
            ->where('station_id', $station_id)
            ->where('balance', '!=', 0)
            ->whereNull('ppmp_items.deleted_at')
            ->orderBy('ppmp_items.description', 'asc') // Order by description of ppmp_items
            ->get();

        return view('user.purchase_request_item.create', compact('id', 'items', 'units'));
    }

    public function store(StorePrItemRequest $request)
    {
        $data = $request->all();
        $id = $request->purchase_request_id;
        $ppmp_id = $request->ppmp_item_id;
        
        if (!is_null($ppmp_id)) {
            $balance = $request->available_quantity - $request->quantity;
            $requested = $request->quantity;

            $purchaseItem = PpmpItem::where('id', $ppmp_id)->first();
            $purchaseItem->balance = $balance;
            $purchaseItem->requested = $requested;
            $purchaseItem->update();
        }
            
        $purchaseRequestItem = PurchaseRequestItem::create($data);
        
        return redirect()->route('user.purchase_request_item.index', compact('id'));
    }

    public function edit(PurchaseRequestItem $purchaseRequestItem)
    {
        abort_if(Gate::denies('purchase_request_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $units = Unit::all()->sortBy('unit');

        return view('user.purchase_request_item.edit', compact('purchaseRequestItem', 'units'));
    }

    public function update(UpdatePrItemRequest $request, PurchaseRequestItem $purchaseRequestItem)
    {
        $id = $purchaseRequestItem->purchase_request_id;
        $purchaseRequestItem->update($request->all());        

        return redirect()->route('user.purchase_request_item.index', compact('id'));
    }

    public function show(PurchaseRequestItem $purchase_request_item)
    {
        abort_if(Gate::denies('purchase_request_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('user.purchase_request_item.show', compact('purchase_request_item'));
    }
    
    public function destroy(PurchaseRequestItem $purchaseRequestItem)
    {
        abort_if(Gate::denies('purchase_request_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ppmpItem = PpmpItem::find($purchaseRequestItem->ppmp_item_id);
        $ppmpItem->balance = $ppmpItem->balance + $purchaseRequestItem->quantity;
        $ppmpItem->requested = $ppmpItem->requested - $purchaseRequestItem->quantity;
        $ppmpItem->save();

        $purchaseRequestItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyPrItemRequest $request)
    {
        $purchaseRequestItems = PurchaseRequestItem::whereIn('id', $request->input('ids'))->get();

        foreach ($purchaseRequestItems as $purchaseRequestItem) {
            // Find the related PpmpItem
            $ppmpItem = PpmpItem::find($purchaseRequestItem->ppmp_item_id);

            if ($ppmpItem) {
                // Update balance and requested fields
                $ppmpItem->balance += $purchaseRequestItem->quantity;
                $ppmpItem->requested -= $purchaseRequestItem->quantity;
                $ppmpItem->save();
            }

            // Delete the PurchaseRequestItem
            $purchaseRequestItem->delete();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
