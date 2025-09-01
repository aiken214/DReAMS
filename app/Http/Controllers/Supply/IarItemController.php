<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIarItemRequest;
use App\Http\Requests\StoreIarItemRequest;
use App\Http\Requests\UpdateIarItemRequest;
use App\Http\Requests\StoreStockCardRequest;
use App\Http\Requests\StoreSemiExpendableCardRequest;
use App\Http\Requests\StorePropertyCardRequest;
use App\Models\IarItem;
use App\Models\Iar;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequestItem;
use App\Models\StockCard;
use App\Models\SemiExpendableCard;
use App\Models\PropertyCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class IarItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('iar_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;

        return view('supply.iar_item.index', compact('id'));
    }

    public function getIarItems(Request $request)
    {            
        $id = $request->iar_id;  

        $data = IarItem::with([
            'stocks:iar_item_id,issued_quantity', // Select only balance_quantity from stocks
            'semi_expendables:iar_item_id,issued_quantity', // Select only balance_quantity from semi_expendables
            'properties:iar_item_id,issued_quantity', // Select only balance_quantity from properties
        ])->where('iar_id', $id)->orderBy('id', 'asc')->get();

        // Use DataTables with the query
        return datatables($data)
            ->editColumn('issued_quantity', function ($row) {
                $totalIssuedQuantity = $row->stocks->sum('issued_quantity') +
                                    $row->semi_expendables->sum('issued_quantity') +
                                    $row->properties->sum('issued_quantity');
                return $totalIssuedQuantity;
            })
            ->rawColumns(['issued_quantity'])
            ->make(true);  

    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('iar_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
 
        $id = $request->id;
        $purchase_order_id = Iar::find($id)->purchase_order_id;
        
        $purchaseOrderItems = PurchaseOrderItem::where('purchase_order_id', $purchase_order_id)
            ->where(function ($query) {
                $query->where('status', '!=', 'Complete')
                    ->orWhereNull('status'); // Include NULL status values
            })
            ->get();

        return view('supply.iar_item.create', compact('id', 'purchaseOrderItems'));
    }

    public function store(StoreIarItemRequest $request, StoreStockCardRequest $storeStockCardRequest, StoreSemiExpendableCardRequest $storeSemiExpendableCardRequest, StorePropertyCardRequest $storePropertyCardRequest)
    {
        abort_if(Gate::denies('iar_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->iar_id;     
        $data = $request->all();
        $purchase_order_item_id = $request->purchase_order_item_id;
        
        $quantity = $request->quantity;
        $unit_price = $request->unit_price;
        $amount = $quantity * $unit_price;
       
        PurchaseOrderItem::where('id', $purchase_order_item_id)->update(['status' => $request->status]);      
        $iarItem = IarItem::create($data);

        // Create Stock record using required fields from IarItem
        $itemData = [
            'iar_id'            => $iarItem->iar_id, // Assuming Stock has a foreign key reference to Iar
            'iar_item_id'       => $iarItem->id, // Assuming Stock has a foreign key reference to IarItem
            'stock_no'          => $iarItem->stock_no, // Example fields
            'description'       => $iarItem->description, 
            'type'              => $iarItem->type, 
            'category'          => $iarItem->category, 
            'status'            => $iarItem->status, 
            'unit'              => $iarItem->unit, 
            'unit_price'        => $request->unit_price, 
            'amount'            => $amount, 
            'receipt_quantity'  => $iarItem->quantity, 
            'balance_quantity'  => $iarItem->quantity,
            'issued_quantity'   => 0,
        ];

        // Normalize category to prevent case sensitivity issues
        $category = strtolower(trim($iarItem->category));

        if ($category === 'consumables') {
            $stock = StockCard::create($itemData);
        } elseif ($category === 'hvse' || $category === 'lvse') {
            $semiExpendable = SemiExpendableCard::create($itemData);
        } elseif ($category === 'ppe') {
            $property = PropertyCard::create($itemData);
        }

        return redirect()->route('supply.iar_item.index', compact('id'));
    }

    public function createFromPettyCash(Request $request)
    {
        abort_if(Gate::denies('iar_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;
        $purchase_request_id = Iar::find($id)->purchase_request_id;
  
        $purchaseRequestItems = PurchaseRequestItem::where('purchase_request_id', $purchase_request_id)->get();

        return view('supply.iar_item.create_from_petty_cash', compact('id', 'purchaseRequestItems'));
    }

    public function storeFromPettyCash(StoreIarItemRequest $request, StoreStockCardRequest $storeStockCardRequest, StoreSemiExpendableCardRequest $storeSemiExpendableCardRequest, StorePropertyCardRequest $storePropertyCardRequest)
    {
        abort_if(Gate::denies('iar_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->iar_id;     
        $data = $request->all();
        $purchase_request_item_id = $request->purchase_request_item_id;
        
        $quantity = $request->quantity;
        $unit_price = $request->unit_price;
        $amount = $quantity * $unit_price;
            
        $iarItem = IarItem::create($data);
        $iarItem_id = $iarItem->id;
        PurchaseRequestItem::where('id', $purchase_request_item_id)->update(['petty_cash_iar_item_id' => $iarItem_id]);  

        // Create Stock record using required fields from IarItem
        $itemData = [
            'iar_id'            => $iarItem->iar_id, // Assuming Stock has a foreign key reference to Iar
            'iar_item_id'       => $iarItem->id, // Assuming Stock has a foreign key reference to IarItem
            'stock_no'          => $iarItem->stock_no, // Example fields
            'description'       => $iarItem->description, 
            'type'              => $iarItem->type, 
            'category'          => $iarItem->category, 
            'status'            => $iarItem->status, 
            'unit'              => $iarItem->unit, 
            'unit_price'        => $request->unit_price, 
            'amount'            => $amount, 
            'receipt_quantity'  => $iarItem->quantity, 
            'balance_quantity'  => $iarItem->quantity,
            'issued_quantity'   => 0,
        ];

        // Normalize category to prevent case sensitivity issues
        $category = strtolower(trim($iarItem->category));

        if ($category === 'consumables') {
            $stock = StockCard::create($itemData);
        } elseif ($category === 'hvse' || $category === 'lvse') {
            $semiExpendable = SemiExpendableCard::create($itemData);
        } elseif ($category === 'ppe') {
            $property = PropertyCard::create($itemData);
        }

        return redirect()->route('supply.iar_item.index', compact('id'));
    }


    public function edit(IarItem $iarItem)
    {
        abort_if(Gate::denies('iar_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.iar_item.edit', compact('iarItem'));
    }

    public function update(UpdateIarItemRequest $request, IarItem $iarItem)
    {
        abort_if(Gate::denies('iar_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $iar_item_id = $request->id;
        $id = $request->iar_id;
        $iarItem->update($request->all());        
        
        // Normalize category to prevent case sensitivity issues
        $category = strtolower(trim($iarItem->category));

        if ($category === 'consumables') {
            $stock = Stock::where('iar_item_id', $iar_item_id)->first();
            if ($stock) { // Ensure stock exists before updating
                $stock->type = $request->type;
                $stock->category = $request->category;
                $stock->status = $request->status;
                $stock->save(); // Use `save()` instead of `update()`
            }
        } elseif ($category === 'hvse' || $category === 'lvse') {
            $semiExpendable = SemiExpendableCard::where('iar_item_id', $iar_item_id)->first();
            if ($semiExpendable) { // Ensure stock exists before updating
                $semiExpendable->type = $request->type;
                $semiExpendable->category = $request->category;
                $semiExpendable->status = $request->status;
                $semiExpendable->save(); // Use `save()` instead of `update()`
            }
        } elseif ($category === 'ppe') {
            $property = PropertyCard::where('iar_item_id', $iar_item_id)->first();
            if ($property) { // Ensure stock exists before updating
                $property->type = $request->type;
                $property->category = $request->category;
                $property->status = $request->status;
                $property->save(); // Use `save()` instead of `update()`
            }
        }
        return redirect()->route('supply.iar_item.index', compact('id'));
    }

    public function show(IarItem $iarItem)
    {
        abort_if(Gate::denies('iar_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.iar_item.show', compact('iarItem'));
    }

    public function destroy(IarItem $iarItem)
    {
        abort_if(Gate::denies('iar_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        PurchaseOrderItem::where('id', $iarItem->purchase_order_item_id)->update(['status' => null]);

        // Normalize category to prevent case sensitivity issues
        $category = strtolower(trim($iarItem->category));

        if ($category === 'consumables') {
            $stock = StockCard::where('iar_item_id', $iarItem->id)->first();
            if ($stock) { // Ensure stock exists before deleting
                $stock->delete();
            }
        } elseif ($category === 'hvse' || $category === 'lvse') {
            $semiExpendable = SemiExpendableCard::where('iar_item_id', $iarItem->id)->first();
            if ($semiExpendable) { // Ensure stock exists before deleting
                $semiExpendable->delete();
            }
        } elseif ($category === 'ppe') {
            $property = PropertyCard::where('iar_item_id', $iarItem->id)->first();
            if ($property) { // Ensure stock exists before deleting
                $property->delete();
            }
        }

        
        $iarItem->delete();

        return back();
    }
}
