<?php

namespace App\Http\Controllers\Supply;

use App\Models\RegspiHv;
use App\Models\RegspiLv;
use App\Models\Employee;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RegspiPrintController extends Controller
{
    public function print_hv(Request $request, $from = null, $to = null, $type = null)
    { 
        // Fetch signatories
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
   
        $query = RegspiHv::with([
            'ics_hv:id,entity_name,recipient',
            'ics_hv.ics_item_hv:id,ics_hv_id,semi_expendable_card_id,inventory_item_no,description,type,lifespan,quantity,unit_cost,status,remarks', 
            'ics_hv.ics_item_hv.semi_expendable_card:id,balance_quantity', 
            'rrsp_hv.ics_hv.ics_item_hv.semi_expendable_card',
        ])->orderBy('date', 'desc')->orderBy('id', 'desc'); // No `get()` here        

        // Apply filters for date
        if (!empty($from) && !empty($to)) {
            $query->whereBetween('date', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        // Apply the 'type' filter (directly applied on the 'ics_item_hvs' table)
        if ($type) {
            $query->whereHas('ics_hv.ics_item_hv', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        // Fetch data
        $regSpis = $query->get();

        $data = [];
     
        foreach ($regSpis as $regSpi) {
            // Handle ICS Items
            if (!empty($regSpi->ics_hv_id)) {
                $icsItem = $regSpi->ics_hv->ics_item_hv; // Directly access the single related IcsItemHv
                if ($icsItem) {  // Check if the relationship is not null
                    if (($icsItem->ics_hv->status === null) || ($icsItem->ics_hv->status === 'Issued')) {
                        $data[] = $this->formatData1($icsItem, 'issued');
                    } else {
                        $data[] = $this->formatData1($icsItem, 'reissued');
                    }
                }
            } 
            
            // Handle RRSP Items
            elseif (!empty($regSpi->rrsp_hv_id)) {
                $icsItem = $regSpi->rrsp_hv->ics_hv->ics_item_hv; // Access the related IcsItemHv directly
                if ($icsItem && $icsItem->ics_hv->status === "Returned") {
                    $data[] = $this->formatData1($icsItem, 'returned');
                } elseif ($icsItem && $icsItem->ics_hv->status === "Disposed") {
                    $data[] = $this->formatData1($icsItem, 'disposed');
                }
            }
        }
       
        return view('supply.print.regspi', compact('data', 'hope', 'supply_officer', 'type'));   
    }

    // Helper function to format data
    private function formatData1($item, $type)
    {
        return match ($type) {
            'issued' => [
                'id' => $item->id,
                'date' => $item->ics_hv?->date,
                'reference' => $item->ics_hv?->ics_hv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => $item->quantity,
                'issued_office' => $item->ics_hv?->entity_name . '<br>' . $item->ics_hv?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->unit_cost)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'reissued' => [
                'id' => $item->id,
                'date' => $item->ics_hv?->date, // Fixed field
                'reference' => $item->ics_hv?->ics_hv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => "",
                'issued_office' => "",
                're-issued_qty' => $item->quantity,
                're-issued_office' => $item->ics_hv?->entity_name . '<br>' . $item->ics_hv?->recipient,
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->unit_cost)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'returned' => [
                'id' => $item->id,
                'date' => $item->rrsp_hv?->date,
                'reference' => $item->rrsp_hv?->rrsp_hv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => "",
                'issued_office' => "",
                'returned_qty' => $item->quantity,
                'returned_office' => $item->rrsp_hv?->entity_name . '<br>' . $item->rrsp_hv?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->unit_cost)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'disposed' => [
                'id' => $item->id,
                'date' => $item->rrsp_hv?->date,
                'reference' => $item->rrsp_hv?->rrsp_hv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => "",
                'issued_office' => "",
                'returned_qty' => $item->quantity,
                'returned_office' => $item->rrsp_hv?->entity_name . '<br>' . $item->rrsp_hv?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->unit_cost)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            default => [],
        };
    }

    public function print_lv(Request $request, $from = null, $to = null, $type = null)
    {
        // Fetch signatories
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
    
        $query = RegspiLv::with([
            'ics_lv:id,entity_name,recipient',
            'ics_lv.ics_item_lv:id,ics_lv_id,semi_expendable_card_id,inventory_item_no,description,lifespan,quantity,unit_cost,status,remarks', 
            'ics_lv.ics_item_lv.semi_expendable_card:id,balance_quantity', 
            'rrsp_lv.ics_lv.ics_item_lv.semi_expendable_card',
        ])->orderBy('date', 'desc')->orderBy('id', 'desc'); // No `get()` here        

        // Apply filters for date
        if (!empty($from) && !empty($to)) {
            $query->whereBetween('date', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        // Apply the 'type' filter (directly applied on the 'ics_item_hvs' table)
        if ($type) {
            $query->whereHas('ics_lv.ics_item_lv', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        // Fetch data
        $regSpis = $query->get();
        // dd($regSpis);
        $data = [];
     
        foreach ($regSpis as $regSpi) {
            // Handle ICS Items
            if (!empty($regSpi->ics_lv_id)) {
                $icsItems = $regSpi->ics_lv->ics_item_lv; // Directly access the multiple related IcsItemLv
                foreach ($icsItems as $icsItem) {
                    if ($icsItem) {  // Check if the relationship is not null
                        if (($icsItem->status === null) || ($icsItem->status === 'Issued')) {
                            $data[] = $this->formatData($icsItem, 'issued');
                        } else {
                            $data[] = $this->formatData($icsItem, 'reissued');
                        }
                    }
                }    
            } 
            
            // Handle RRSP Items
            elseif (!empty($regSpi->rrsp_lv_id)) {
                $icsItems = $regSpi->rrsp_lv->ics_lv->ics_item_lv; // Access the related IcsItemLv directly
                foreach ($icsItems as $icsItem) {
                    if ($icsItem && $icsItem->status === "Returned") {
                        $data[] = $this->formatData($icsItem, 'returned');
                    } elseif ($icsItem && $icsItem->ics_lv->status === "Disposed") {
                        $data[] = $this->formatData($icsItem, 'disposed');
                    }
                }
            }
        }
     
        return view('supply.print.regspi', compact('data', 'hope', 'supply_officer', 'type'));   
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
                'issued_office' => $item->ics_lv?->entity_name . '<br>' . $item->ics_lv?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->unit_cost)) * floatval($item->quantity),
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
                're-issued_office' => $item->ics_lv?->entity_name . '<br>' . $item->ics_lv?->recipient,
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->unit_cost)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'returned' => [
                'id' => $item->id,
                'date' => $item->rrsp_lv?->date,
                'reference' => $item->rrsp_lv?->rrsp_lv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => "",
                'issued_office' => "",
                'returned_qty' => $item->quantity,
                'returned_office' => $item->rrsp_lv?->entity_name . '<br>' . $item->rrsp_lv?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->unit_cost)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'disposed' => [
                'id' => $item->id,
                'date' => $item->rrsp_lv?->date,
                'reference' => $item->rrsp_lv?->rrsp_hv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => "",
                'issued_office' => "",
                'returned_qty' => $item->quantity,
                'returned_office' => $item->rrsp_lv?->entity_name . '<br>' . $item->rrsp_lv?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->unit_cost)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            default => [],
        };
    }
}
