<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\RegspiLv;
use App\Models\IcsLv;
use App\Models\IcsItemLv;
use App\Models\RrspLv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RegspiLvController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('regspi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('supply.regspi_lv.index');
    }

    public function getRegspiLv(Request $request)
    {           
        // Fetch data
        $start_date = $request->get('from');
        $end_date = $request->get('to');

        $query = RegspiLv::with([
            'ics_lv:id,entity_name,recipient',
            'ics_lv.ics_item_lv:id,ics_lv_id,semi_expendable_card_id,inventory_item_no,description,type,lifespan,quantity,unit_cost,status,remarks', 
            'ics_lv.ics_item_lv.semi_expendable_card:id,balance_quantity', 
            'rrsp_lv.ics_lv.ics_item_lv.semi_expendable_card',
        ])->orderBy('date', 'desc')->orderBy('id', 'desc'); // No `get()` here        

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [Carbon::parse($start_date)->format('Y-m-d')])
                  ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [Carbon::parse($end_date)->format('Y-m-d')]);
        }

        if ($request->filled('type')) {
            $query->whereHas('ics_lv.ics_item_lv', function ($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        // Fetch data
        $regSpis = $query->get();
     
        $data = [];

        foreach ($regSpis as $regSpi) {
            // Handle ICS Items
            if (!empty($regSpi->ics_lv_id)) {
                foreach ($regSpi->ics_lv->ics_item_lv as $icsItem) {
                    // dd($icsItem);
                    if (($icsItem->ics_lv->status == null) || ($icsItem->ics_lv->status === 'Issued')) {
                        $data[] = $this->formatData($icsItem, 'issued');
                    } else {
                        $data[] = $this->formatData($icsItem, 'reissued');
                    }
                }
            } 
            
            // Handle RRSP Items
            elseif (!empty($regSpi->rrsp_lv_id)) {
                foreach ($regSpi->rrsp_lv->ics_lv->ics_item_lv as $rrspItem) {
                    if ($rrspItem->ics_lv->status === "Returned") {
                        $data[] = $this->formatData($rrspItem, 'returned');
                    } elseif ($rrspItem->ics_lv->status === "Disposed") { // Fixed else
                        $data[] = $this->formatData($rrspItem, 'disposed');
                    }
                }
            }
        }

        return datatables($data)->make(true);        
    }

    // Helper function to format data
    private function formatData($item, $type)
    {
        return match ($type) {
            'issued' => [
                'id' => $item->id,
                'date' => $item->ics_lv?->date,
                'reference' => $item->ics_lv?->ics_lv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => $item->quantity,
                'issued_office' => $item->ics_lv?->entity_name . "," . $item->ics_lv?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',                
                'amount' => floatval($item->unit_cost) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'reissued' => [
                'id' => $item->id,
                'date' => $item->ics_lv?->date, // Fixed field
                'reference' => $item->ics_lv?->ics_lv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => "",
                'issued_office' => "",
                're-issued_qty' => $item->quantity,
                're-issued_office' => $item->ics_lv?->entity_name . "," . $item->ics_lv?->recipient,
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval($item->unit_cost) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'returned' => [
                'id' => $item->id,
                'date' => $item->rrsplv?->date,
                'reference' => $item->rrsplv?->rrsplv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => "",
                'issued_office' => "",
                'returned_qty' => $item->quantity,
                'returned_office' => $item->rrsplv?->entity_name . "," . $item->rrsplv?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval($item->unit_cost) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'disposed' => [
                'id' => $item->id,
                'date' => $item->rrsplv?->date,
                'reference' => $item->rrsplv?->rrsplv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => "",
                'issued_office' => "",
                'returned_qty' => $item->quantity,
                'returned_office' => $item->rrsplv?->entity_name . "," . $item->rrsplv?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval($item->unit_cost) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            default => [],
        };
    }
}