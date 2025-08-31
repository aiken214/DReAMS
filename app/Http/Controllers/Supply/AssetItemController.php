<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAssetItemRequest;
use App\Http\Requests\StoreAssetItemRequest;
use App\Http\Requests\UpdateAssetItemRequest;
use App\Http\Requests\StoreStockCardRequest;
use App\Http\Requests\StoreSemiExpendableCardRequest;
use App\Http\Requests\StorePropertyCardRequest;
use App\Models\Asset;
use App\Models\AssetItem;
use App\Models\ItemsList;
use App\Models\StockCard;
use App\Models\SemiExpendableCard;
use App\Models\PropertyCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class AssetItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('asset_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;

        return view('supply.asset_item.index', compact('id'));
    }

    public function getAssetItems(Request $request)
    {            
        $id = $request->asset_id; 
               
        $data = AssetItem::with(['stocks:asset_item_id,issued_quantity', // Select only balance_quantity from stocks
                'semi_expendables:asset_item_id,issued_quantity', // Select only balance_quantity from semi_expendables
                'properties:asset_item_id,issued_quantity', // Select only balance_quantity from properties
            ])->where('asset_id', $id)->orderBy('id', 'asc')->get();

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
        abort_if(Gate::denies('asset_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;
        $items = ItemsList::all()->sortBy('description');
       
        return view('supply.asset_item.create', compact('id', 'items'));
    }
    
    public function store(StoreAssetItemRequest $request, StoreStockCardRequest $storeStockCardRequest, StoreSemiExpendableCardRequest $storeSemiExpendableCardRequest, StorePropertyCardRequest $storePropertyCardRequest)
    {
        $id = $request->asset_id;     
        $data = $request->all();
        
        $quantity = is_numeric($request->quantity) ? (float) $request->quantity : 0;
        $unit_price = is_numeric(str_replace(',', '', $request->unit_price)) 
            ? (float) str_replace(',', '', $request->unit_price) 
            : 0;
        $amount = $quantity * $unit_price;
            
        $assetItem = AssetItem::create($data);

        // Create Stock record using required fields from IarItem
        $itemData = [
            'asset_id'          => $assetItem->asset_id, // Assuming Stock has a foreign key reference to Asset
            'asset_item_id'     => $assetItem->id, // Assuming Stock has a foreign key reference to AssetItem
            'stock_no'          => $assetItem->stock_no, // Example fields
            'description'       => $assetItem->description, 
            'type'              => $assetItem->type, 
            'category'          => $assetItem->category, 
            'status'            => $assetItem->status, 
            'unit'              => $assetItem->unit, 
            'unit_price'        => $request->unit_price, 
            'amount'            => $amount, 
            'receipt_quantity'  => $assetItem->quantity, 
            'balance_quantity'  => $assetItem->quantity,
            'issued_quantity'   => 0,
        ];

        // Normalize category to prevent case sensitivity issues
        $category = strtolower(trim($assetItem->category));

        if ($category === 'consumables') {
            $stock = StockCard::create($itemData);
        } elseif ($category === 'hvse' || $category === 'lvse') {
            $semiExpendable = SemiExpendableCard::create($itemData);
        } elseif ($category === 'ppe') {
            $property = PropertyCard::create($itemData);
        }

        return redirect()->route('supply.asset_item.index', compact('id'));
    }

    public function edit(AssetItem $assetItem)
    {
        abort_if(Gate::denies('asset_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.asset_item.edit', compact('assetItem'));
    }

    public function update(UpdateAssetItemRequest $request, AssetItem $assetItem)
    {
        $asset_item_id = $request->id;
        $id = $request->asset_id;

        $assetCategory = strtolower(trim($assetItem->category));
        $requestCategory = strtolower(trim($request->category));

        if ($assetCategory != $requestCategory) {
            // Initialize $itemData to null
            $itemData = null;

            if ($assetCategory === 'consumables') {
                $stockData = StockCard::where('asset_item_id', $asset_item_id)->first();
                $itemData = $stockData->replicate();
                $stockData->delete();
            } elseif ($assetCategory === 'hvse' || $assetCategory === 'lvse') {
                $semiExpendableData = SemiExpendableCard::where('asset_item_id', $asset_item_id)->first();
                $itemData = $semiExpendableData->replicate();
                $semiExpendableData->delete();
            } elseif ($assetCategory === 'ppe') {
                $propertyData = PropertyCard::where('asset_item_id', $asset_item_id)->first();
                $itemData = $propertyData->replicate();
                $propertyData->delete();
            }

            if ($itemData) {
                $origQuantity = $itemData->balance_quantity + $itemData->issued_quantity;
                $newQuantity = $request->quantity;

                if ($newQuantity > $origQuantity) {
                    $quantity = $newQuantity - $origQuantity;
                    $receiptQuantity = $origQuantity + $quantity;
                    $balanceQuantity = $itemData->balance_quantity + $quantity;
                } elseif ($newQuantity < $origQuantity) {
                    $quantity = $origQuantity - $newQuantity;
                    if ($quantity > $itemData->balance_quantity) {
                        throw new \Exception("Insufficient balance to issue items.");
                    } else {
                        $receiptQuantity = $newQuantity;
                        $balanceQuantity = $itemData->balance_quantity - $quantity;
                    }
                } else {
                    $receiptQuantity = $itemData->receipt_quantity;
                    $balanceQuantity = $itemData->balance_quantity;
                }

                // Convert $itemData to array if it's an Eloquent model instance
                if ($itemData instanceof \Illuminate\Database\Eloquent\Model) {
                    $itemData = $itemData->toArray();
                }

                $itemData['receipt_quantity'] = $receiptQuantity;
                $itemData['balance_quantity'] = $balanceQuantity;
                $itemData['type'] = $request->type;
                $itemData['category'] = $request->category;
                $itemData['status'] = $request->status;

                if ($requestCategory === 'consumables') {
                    $stock = StockCard::create($itemData);
                } elseif ($requestCategory === 'hvse' || $requestCategory === 'lvse') {
                    $semiExpendable = SemiExpendableCard::create($itemData);
                } elseif ($requestCategory === 'ppe') {
                    $property = PropertyCard::create($itemData);
                }
            } else {
                throw new \Exception("Item data not found for asset item ID: $asset_item_id");
            }
        } else {

            $itemData = null;

            if ($requestCategory === 'consumables') {
                $itemData = StockCard::where('asset_item_id', $asset_item_id)->first();
            } elseif ($requestCategory === 'hvse' || $requestCategory === 'lvse') {
                $itemData = SemiExpendableCard::where('asset_item_id', $asset_item_id)->first();
            } elseif ($requestCategory === 'ppe') {
                $itemData = PropertyCard::where('asset_item_id', $asset_item_id)->first();
            }

            if ($itemData) {
                $origQuantity = $itemData->balance_quantity + $itemData->issued_quantity;
                $newQuantity = $request->quantity;

                if ($newQuantity > $origQuantity) {
                    $quantity = $newQuantity - $origQuantity;
                    $receiptQuantity = $origQuantity + $quantity;
                    $balanceQuantity = $itemData->balance_quantity + $quantity;
                } elseif ($newQuantity < $origQuantity) {
                    $quantity = $origQuantity - $newQuantity;
                    if ($quantity > $itemData->balance_quantity) {
                        throw new \Exception("Insufficient balance to issue items.");
                    } else {
                        $receiptQuantity = $newQuantity;
                        $balanceQuantity = $itemData->balance_quantity - $quantity;
                    }
                } else {
                    $receiptQuantity = $itemData->receipt_quantity;
                    $balanceQuantity = $itemData->balance_quantity;
                }

                // Update the existing record
                $itemData->receipt_quantity = $receiptQuantity;
                $itemData->balance_quantity = $balanceQuantity;
                $itemData->type = $request->type;
                $itemData->category = $request->category;
                $itemData->status = $request->status;
                $itemData->save(); // Save the changes to the database
            } else {
                throw new \Exception("Item data not found for asset item ID: $asset_item_id");
            }
        }

        $assetItem->update($request->all());

        return redirect()->route('supply.asset_item.index', compact('id'));
    }

    public function show(AssetItem $assetItem)
    {
        abort_if(Gate::denies('asset_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.asset_item.show', compact('assetItem'));
    }

    public function destroy(AssetItem $assetItem)
    {
        abort_if(Gate::denies('asset_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assetItem->delete();

        return back();
    }
}
