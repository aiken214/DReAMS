<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDonationItemRequest;
use App\Http\Requests\StoreDonationItemRequest;
use App\Http\Requests\UpdateDonationItemRequest;
use App\Http\Requests\StoreStockCardRequest;
use App\Http\Requests\StoreSemiExpendableCardRequest;
use App\Http\Requests\StorePropertyCardRequest;
use App\Models\Donation;
use App\Models\DonationItem;
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

class DonationItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('donation_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;

        return view('supply.donation_item.index', compact('id'));
    }

    public function getDonationItems(Request $request)
    {            
        $id = $request->donation_id;        
        $data = DonationItem::with(['donation:id'])->where('donation_id', $id)->orderBy('id', 'asc')->get();

        return datatables($data)->make(true);  

    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('donation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;
        $items = ItemsList::all()->sortBy('description');
       
        return view('supply.donation_item.create', compact('id', 'items'));
    }
    
    public function store(StoreDonationItemRequest $request, StoreStockCardRequest $storeStockCardRequest, StoreSemiExpendableCardRequest $storeSemiExpendableCardRequest, StorePropertyCardRequest $storePropertyCardRequest)
    {
        abort_if(Gate::denies('donation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->donation_id;     
        $data = $request->all();
        // dd($data);
        $quantity = is_numeric($request->quantity) ? (float) $request->quantity : 0;
        $unit_price = is_numeric(str_replace(',', '', $request->unit_price)) 
            ? (float) str_replace(',', '', $request->unit_price) 
            : 0;
        $amount = $quantity * $unit_price;
            
        $donationItem = DonationItem::create($data);

        // Create Stock record using required fields from IarItem
        $itemData = [
            'donation_id'       => $donationItem->donation_id, // Assuming Stock has a foreign key reference to Donation
            'donation_item_id'  => $donationItem->id, // Assuming Stock has a foreign key reference to DonationItem
            'stock_no'          => $donationItem->stock_no, // Example fields
            'description'       => $donationItem->description, 
            'type'              => $donationItem->type, 
            'category'          => $donationItem->category, 
            'status'            => $donationItem->status, 
            'unit'              => $donationItem->unit, 
            'unit_price'        => $request->unit_price, 
            'amount'            => $amount, 
            'receipt_quantity'  => $donationItem->quantity, 
            'balance_quantity'  => $donationItem->quantity,
            'issued_quantity'   => 0,
        ];

        // Normalize category to prevent case sensitivity issues
        $category = strtolower(trim($donationItem->category));

        if ($category === 'consumables') {
            $stock = StockCard::create($itemData);
        } elseif ($category === 'hvse' || $category === 'lvse') {
            $semiExpendable = SemiExpendableCard::create($itemData);
        } elseif ($category === 'ppe') {
            $property = PropertyCard::create($itemData);
        }

        return redirect()->route('supply.donation_item.index', compact('id'));
    }

    public function edit(DonationItem $donationItem)
    {
        abort_if(Gate::denies('donation_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.donation_item.edit', compact('donationItem'));
    }

    public function update(UpdateDonationItemRequest $request, DonationItem $donationItem)
    {
        abort_if(Gate::denies('donation_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $donation_item_id = $request->id;
        $id = $request->donation_id;

        $donationCategory = strtolower(trim($donationItem->category));
        $requestCategory = strtolower(trim($request->category));

        if ($donationCategory != $requestCategory) {
            // Initialize $itemData to null
            $itemData = null;

            if ($donationCategory === 'consumables') {
                $stockData = StockCard::where('donation_item_id', $donation_item_id)->first();
                $itemData = $stockData->replicate();
                $stockData->delete();
            } elseif ($donationCategory === 'hvse' || $donationCategory === 'lvse') {
                $semiExpendableData = SemiExpendableCard::where('donation_item_id', $donation_item_id)->first();
                $itemData = $semiExpendableData->replicate();
                $semiExpendableData->delete();
            } elseif ($donationCategory === 'ppe') {
                $propertyData = PropertyCard::where('donation_item_id', $donation_item_id)->first();
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
                throw new \Exception("Item data not found for donatioon item ID: $donation_item_id");
            }
        } else {

            $itemData = null;

            if ($requestCategory === 'consumables') {
                $itemData = StockCard::where('donation_item_id', $donation_item_id)->first();
            } elseif ($requestCategory === 'hvse' || $requestCategory === 'lvse') {
                $itemData = SemiExpendableCard::where('donation_item_id', $donation_item_id)->first();
            } elseif ($requestCategory === 'ppe') {
                $itemData = PropertyCard::where('donation_item_id', $donation_item_id)->first();
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
                throw new \Exception("Item data not found for donation item ID: $donation_item_id");
            }
        }

        $donationItem->update($request->all());

        return redirect()->route('supply.donation_item.index', compact('id'));
    }

    public function show(DonationItem $donationItem)
    {
        abort_if(Gate::denies('donation_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.donation_item.show', compact('DonationItem'));
    }

    public function destroy(DonationItem $donationItem)
    {
        abort_if(Gate::denies('donation_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $donationItem->delete();

        return back();
    }
}
