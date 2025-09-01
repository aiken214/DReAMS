<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRrspItemLvRequest;
use App\Http\Requests\StoreRrspItemLvRequest;
use App\Http\Requests\UpdateRrspItemLvRequest;
use App\Models\RrspLv;
use App\Models\IcsLv;
use App\Models\IcsItemLv;
use App\Models\RrspItemLv;
use App\Models\SemiExpendableCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RrspItemLvController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('rrsp_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
   
        $id = $request->id;
        
        return view('supply.rrsp_item_lv.index', compact('id'));
    }

    public function getRrspItemLv(Request $request)
    {     
        $id = $request->rrsp_lv_id;   
        $rrsp = RrspLv::with('ics_lv')->find($id);
       
        // Retrieve only data filtered by ics_hv_id
        $query = RrspItemLv::where('rrsp_lv_id', $rrsp->id); 

        // Use DataTables query builder for better performance
        return datatables()->eloquent($query)->make(true); 
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('rrsp_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;
        $rrspLv = RrspLv::find($id);
        $icsItemLvs = IcsItemLv::where('ics_lv_id', $rrspLv->ics_lv_id)
            ->whereHas('semi_expendable_card', function ($query) {
                $query->where('issued_quantity', '>', 0);
            })
            ->get();
      
        return view('supply.rrsp_item_lv.create', compact('id', 'icsItemLvs'));
    }
    
    public function store(StoreRrspItemLvRequest $request)
    {
        abort_if(Gate::denies('rrsp_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->rrsp_lv_id;
        $icsId = $request->item_id;
        $returned_quantity = is_numeric($request->returned_quantity) ? (float) $request->returned_quantity : 0;
        $unit_cost = is_numeric(str_replace(',', '', $request->unit_cost)) 
            ? (float) str_replace(',', '', $request->unit_cost) 
            : 0;
        $amount = $returned_quantity * $unit_cost;

        DB::transaction(function () use ($request, $id, $icsId, $returned_quantity, $unit_cost, $amount) {
            $icsItemLv = IcsItemLv::find($icsId);

            $itemData = [
                'quantity'               => $returned_quantity,
                'unit'                   => $icsItemLv->unit,
                'unit_cost'              => $icsItemLv->unit_cost,
                'total_cost'             => $amount,
                'description'            => $icsItemLv->description,
                'inventory_item_no'      => $icsItemLv->inventory_item_no,
                'lifespan'               => $icsItemLv->lifespan,
                'serial_no'              => $icsItemLv->serial_no,
                'type'                   => $icsItemLv->type,
                'status'                 => $icsItemLv->status,
                'serviceability'         => $request->serviceability,
                'remarks'                => "Returned {$returned_quantity} out of {$icsItemLv->quantity}",
                'rrsp_lv_id'             => $id,
                'ics_item_lv_id'         => $icsItemLv->id,
                'ris_item_id'            => $icsItemLv->ris_item_id,
                'semi_expendable_card_id'=> $icsItemLv->semi_expendable_card_id,
            ];

            $rrsp = RrspItemLv::create($itemData);

            $icsItemLv->update([
                'status'         => "Returned",
                'serviceability' => $request->serviceability,
                'remarks'        => "Item returned on {$request->date}",
            ]);

            $semiExpendableCard = SemiExpendableCard::find($rrsp->semi_expendable_card_id);

            if ($semiExpendableCard) {
                $semiExpendableCard->issued_quantity = max(0, $semiExpendableCard->issued_quantity - $returned_quantity);
                $semiExpendableCard->balance_quantity += $returned_quantity;
                $semiExpendableCard->save();
            }

        });

        return redirect()->route('supply.rrsp_item_lv.index', ['id' => $id]);
    }

    public function edit(RrspItemLv $rrspItemLv)
    {
        abort_if(Gate::denies('rrsp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
   
        $rrspItemLv->load(['ics_item_lv:id,quantity']);
       
        return view('supply.rrsp_item_lv.edit', compact('rrspItemLv'));
    }

    public function update(UpdateRrspItemLvRequest $request, RrspItemLv $rrspItemLv)
    {
        abort_if(Gate::denies('rrsp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $id = $request->rrsp_lv_id;
        $icsId = $request->ics_item_lv_id;
        $returned_quantity = is_numeric($request->returned_quantity) ? (float) $request->returned_quantity : 0;
        $unit_cost = is_numeric(str_replace(',', '', $request->unit_cost)) 
            ? (float) str_replace(',', '', $request->unit_cost) 
            : 0;
        $amount = $returned_quantity * $unit_cost;

        DB::transaction(function () use ($request, $id, $icsId, $returned_quantity, $unit_cost, $amount, $rrspItemLv) {
            $icsItemLv = IcsItemLv::find($icsId);
            $old_quantity = $rrspItemLv->quantity; // previous returned quantity

            $itemData = [
                'quantity'               => $returned_quantity,
                'unit'                   => $icsItemLv->unit,
                'unit_cost'              => $icsItemLv->unit_cost,
                'total_cost'             => $amount,
                'description'            => $icsItemLv->description,
                'inventory_item_no'      => $icsItemLv->inventory_item_no,
                'lifespan'               => $icsItemLv->lifespan,
                'serial_no'              => $icsItemLv->serial_no,
                'type'                   => $icsItemLv->type,
                'status'                 => $icsItemLv->status,
                'serviceability'         => $request->serviceability,
                'remarks'                => "Returned {$returned_quantity} out of {$icsItemLv->quantity}",
                'rrsp_lv_id'             => $id,
                'ics_item_lv_id'         => $icsItemLv->id,
                'ris_item_id'            => $icsItemLv->ris_item_id,
                'semi_expendable_card_id'=> $icsItemLv->semi_expendable_card_id,
            ];

            $rrspItemLv->update($itemData);

            $icsItemLv->update([
                'status'         => "Returned",
                'serviceability' => $request->serviceability,
                'remarks'        => "Returned {$returned_quantity} out of {$icsItemLv->quantity}",
            ]);

            $semiExpendableCard = SemiExpendableCard::find($rrspItemLv->semi_expendable_card_id);

            if ($semiExpendableCard) {
                // Revert the old returned quantity
                $semiExpendableCard->issued_quantity += $old_quantity;
                $semiExpendableCard->balance_quantity -= $old_quantity;

                // Apply the new returned quantity
                $semiExpendableCard->issued_quantity = max(0, $semiExpendableCard->issued_quantity - $returned_quantity);
                $semiExpendableCard->balance_quantity += $returned_quantity;

                $semiExpendableCard->save();
            }
        });

        return redirect()->route('supply.rrsp_item_lv.index', ['id' => $id]);
    }

    public function show(RrspItemLv $rrspItemLv)
    {
        abort_if(Gate::denies('rrsp_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.rrsp_item_lv.show', compact('rrspItemLv'));
    }  

    public function destroy(RrspItemLv $rrspItemLv)
    {
        abort_if(Gate::denies('rrsp_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Get the single IcsItemLv record
        $icsItemLv = IcsItemLv::where('id', $rrspItemLv->ics_item_lv_id)->first();

        if ($icsItemLv) {
            // Reset its fields
            // $icsItemLv->update([
            //     'status'         => null,
            //     'serviceability' => null,
            //     'remarks'        => null,
            // ]);

            // Update the related SemiExpendableCard
            if ($icsItemLv->semi_expendable_card_id) {
                $semiExpendableCard = SemiExpendableCard::find($icsItemLv->semi_expendable_card_id);
              
                if ($semiExpendableCard) {
                    $semiExpendableCard->update([
                        'issued_quantity' => $semiExpendableCard->issued_quantity + $rrspItemLv->quantity,
                        'balance_quantity' => $semiExpendableCard->balance_quantity - $rrspItemLv->quantity,
                    ]);
                }
            }
        }        

        $rrspItemLv->delete();

        return back();
    }
}
