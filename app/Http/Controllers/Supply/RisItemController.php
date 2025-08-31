<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRisItemRequest;
use App\Http\Requests\StoreRisItemRequest;
use App\Http\Requests\UpdateRisItemRequest;
use App\Models\RisItem;
use App\Models\Ris;
use App\Models\Iar;
use App\Models\Asset;
use App\Models\Donation;
use App\Models\StockCard;
use App\Models\SemiExpendableCard;
use App\Models\PropertyCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RisItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('ris_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;

        return view('supply.ris_item.index', compact('id'));
    }

    public function getRisItems(Request $request)
    {            
        $id = $request->ris_id;        
        $data = RisItem::with(['ris'])->where('ris_id', $id)->orderBy('id', 'asc')->get();

        // Use DataTables with the query
        return datatables($data)
            ->editColumn('available', function ($row) {
                return ($row->balance_quantity > 0) ? 'Yes' : 'No'; 
            })
            ->rawColumns(['available']) // Only needed if you're returning HTML
            ->make(true); 

    }
    
    public function create(Request $request)
    {
        abort_if(Gate::denies('ris_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $id = $request->id;
        $iar_id = Ris::find($id)->iar_id;
        $asset_id = Ris::find($id)->asset_id;
        $donation_id = Ris::find($id)->donation_id;
        
        if (!empty($iar_id)){
            $iarItems = Iar::with([
                    'stocks' => function ($query) {
                        $query->select('id', 'iar_id', 'stock_no', 'description', 'unit', 'balance_quantity', 'category')
                            ->where('balance_quantity', '>', 0);
                    },
                    'semi_expendables' => function ($query) {
                        $query->select('id', 'iar_id', 'stock_no', 'description', 'unit', 'balance_quantity', 'category')
                            ->where('balance_quantity', '>', 0);
                    },
                    'properties' => function ($query) {
                        $query->select('id', 'iar_id', 'stock_no', 'description', 'unit', 'balance_quantity', 'category')
                            ->where('balance_quantity', '>', 0);
                    }
                ])
                ->where('id', $iar_id)
                ->select('id', 'iar_no', 'purchase_order_id')
                ->get();

            $risItems = collect(); // Initialize an empty collection

            foreach ($iarItems as $item) {
                $risItems = $risItems->merge($item->stocks);
                $risItems = $risItems->merge($item->semi_expendables);
                $risItems = $risItems->merge($item->properties);
            }
        } elseif (!empty($asset_id)){
            $assetItems = Asset::with([
                    'stocks' => function ($query) {
                        $query->select('id', 'asset_id', 'stock_no', 'description', 'unit', 'balance_quantity', 'category')
                            ->where('balance_quantity', '>', 0);
                    },
                    'semi_expendables' => function ($query) {
                        $query->select('id', 'asset_id', 'stock_no', 'description', 'unit', 'balance_quantity', 'category')
                            ->where('balance_quantity', '>', 0);
                    },
                    'properties' => function ($query) {
                        $query->select('id', 'asset_id', 'stock_no', 'description', 'unit', 'balance_quantity', 'category')
                            ->where('balance_quantity', '>', 0);
                    }
                ])
                ->where('id', $asset_id)
                ->select('id', 'asset_no')
                ->get();

            $risItems = collect(); // Initialize an empty collection

            foreach ($assetItems as $item) {
                $risItems = $risItems->merge($item->stocks);
                $risItems = $risItems->merge($item->semi_expendables);
                $risItems = $risItems->merge($item->properties);
            }
        } elseif (!empty($donation_id)){
            $donationItems = Donation::with([
                    'stocks' => function ($query) {
                        $query->select('id', 'donation_id', 'stock_no', 'description', 'unit', 'balance_quantity', 'category')
                            ->where('balance_quantity', '>', 0);
                    },
                    'semi_expendables' => function ($query) {
                        $query->select('id', 'donation_id', 'stock_no', 'description', 'unit', 'balance_quantity', 'category')
                            ->where('balance_quantity', '>', 0);
                    },
                    'properties' => function ($query) {
                        $query->select('id', 'donation_id', 'stock_no', 'description', 'unit', 'balance_quantity', 'category')
                            ->where('balance_quantity', '>', 0);
                    }
                ])
                ->where('id', $donation_id)
                ->select('id', 'donation_no')
                ->get();

            $risItems = collect(); // Initialize an empty collection

            foreach ($donationItems as $item) {
                $risItems = $risItems->merge($item->stocks);
                $risItems = $risItems->merge($item->semi_expendables);
                $risItems = $risItems->merge($item->properties);
            }
        }

        return view('supply.ris_item.create', compact('id','risItems'));
    }

    public function store(StoreRisItemRequest $request)
    {
        $id = $request->ris_id;     
        $data = $request->all();

        // Normalize category to prevent case sensitivity issues
        $category = strtolower(trim($data['category']));        

        $item_id = $data['item_id']; // Ensure this is set

        if ($category === 'consumables') {
            $stock = StockCard::where('id', $item_id)->first(); 
            if ($stock) { // Ensure $stock is not null
                $stock->balance_quantity -= $data['issued_quantity'];
                $stock->issued_quantity += $data['issued_quantity'];
                $stock->update();
            }
            $data['stock_card_id'] = $item_id;
        } elseif ($category === 'hvse' || $category === 'lvse') {
            $semiExpendable = SemiExpendableCard::where('id', $item_id)->first();
            if ($semiExpendable) { // Ensure $semiExpendable is not null
                $semiExpendable->balance_quantity -= $data['issued_quantity'];
                $semiExpendable->issued_quantity += $data['issued_quantity'];
                $semiExpendable->update();
            }
            $data['semi_expendable_card_id'] = $item_id;
        } elseif ($category === 'ppe') {            
            $property = PropertyCard::where('id', $item_id)->first(); 
            if ($property) { // Ensure $property is not null
                $property->balance_quantity -= $data['issued_quantity'];
                $property->issued_quantity += $data['issued_quantity'];
                $property->update();
            }
            $data['property_card_id'] = $item_id;
        }      

        $risItem = RisItem::create($data);   

        return redirect()->route('supply.ris_item.index', ['id' => $id]);
    }

    public function edit(RisItem $risItem)
    {
        abort_if(Gate::denies('ris_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.ris_item.edit', compact('risItem'));
    }

    public function update(UpdateRisItemRequest $request, RisItem $risItem)
    {
        $id = $request->ris_id;
        $risItemId = $request->id;
        $data = $request->all();
        
        // Get RIS Item
        $risItemData = RisItem::find($risItemId);

        if (!$risItemData) {
            return redirect()->back()->with('error', 'RIS Item not found.');
        }

        // Normalize category to prevent case sensitivity issues
        $category = isset($data['category']) ? strtolower(trim($data['category'])) : '';        

        // Get related card IDs
        $stock_card_id = $data['stock_card_id'] ?? null;
        $semi_expendable_card_id = $data['semi_expendable_card_id'] ?? null;
        $property_card_id = $data['property_card_id'] ?? null;

        if ($category === 'consumables' && $stock_card_id) {
            $stock = StockCard::where('id', $stock_card_id)->first();
            if ($stock) {
                // Reset Issued Quantity
                $stock->issued_quantity -= $risItemData->issued_quantity;
                $stock->balance_quantity += $risItemData->issued_quantity;
                //Update Ris Item
                $risItemData->balance_quantity = $stock->balance_quantity;
                $risItemData->issued_quantity = $data['issued_quantity'];
                $risItemData->update();
                // Apply new issued quantity
                $stock->balance_quantity -= $data['issued_quantity'];
                $stock->issued_quantity += $data['issued_quantity'];

                $stock->update();
            }
        } elseif (in_array($category, ['hvse', 'lvse']) && $semi_expendable_card_id) {
            $semiExpendable = SemiExpendableCard::where('id', $semi_expendable_card_id)->first();
            if ($semiExpendable) {
                // Reset Issued Quantity
                $semiExpendable->issued_quantity -= $risItemData->issued_quantity;
                $semiExpendable->balance_quantity += $risItemData->issued_quantity;
                //Update Ris Item
                $risItemData->balance_quantity = $semiExpendable->balance_quantity;
                $risItemData->issued_quantity = $data['issued_quantity'];
                $risItemData->update();
                // Apply new issued quantity
                $semiExpendable->balance_quantity -= $data['issued_quantity'];
                $semiExpendable->issued_quantity += $data['issued_quantity'];

                $semiExpendable->update();
            }
        } elseif ($category === 'ppe' && $property_card_id) {
            $property = PropertyCard::where('id', $property_card_id)->first();
            if ($property) {
                // Reset Issued Quantity
                $property->issued_quantity -= $risItemData->issued_quantity;
                $property->balance_quantity += $risItemData->issued_quantity;
                //Update Ris Item
                $risItemData->balance_quantity = $property->balance_quantity;
                $risItemData->issued_quantity = $data['issued_quantity'];
                $risItemData->update();
                // Apply new issued quantity
                $property->balance_quantity -= $data['issued_quantity'];
                $property->issued_quantity += $data['issued_quantity'];

                $property->update();
            }
        }

        return redirect()->route('supply.ris_item.index', ['id' => $id]);
    }

    public function show(RisItem $risItem)
    {
        abort_if(Gate::denies('ris_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $risItem->load([
            'ris:id,ris_no', 
        ]);

        return view('supply.ris_item.show', compact('risItem'));
    }  
}