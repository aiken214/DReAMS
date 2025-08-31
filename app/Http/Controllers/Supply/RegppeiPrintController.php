<?php

namespace App\Http\Controllers\Supply;

use App\Models\Regppei;
use App\Models\Employee;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RegppeiPrintController extends Controller
{
    public function print(Request $request, $from = null, $to = null, $type = null)
    {
        // Fetch signatories
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
   
        $query = Regppei::with([
            'par:id,entity_name,recipient',
            'par.par_item:id,par_id,property_card_id,property_no,description,date_acquired,quantity,amount,status,remarks', 
            'par.par_item.property_card:id,balance_quantity', 
            'rrppe:id,par_id,date,rrppe_no',
            'rrppe.par:id,entity_name,recipient',
            'rrppe.par.par_item:id,par_id,property_card_id,property_no,description,date_acquired,quantity,amount,status,remarks', 
            'rrppe.par.par_item.property_card:id,balance_quantity', 
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
            $query->whereHas('par.par_item', function ($q) use ($type) {
                $q->where('specific_type', $type);
            });
        }

        // Fetch data
        $regPpeis = $query->get();

        $data = [];
     
        foreach ($regPpeis as $regPpei) {
            // Handle ICS Items
            if (!empty($regPpei->par_id)) {
                $parItem = $regPpei->par->par_item; // Directly access the single related ParItem
                // dd($parItem);
                if ($parItem) {  // Check if the relationship is not null
                    if (($regPpei->par->status === 'Transferred')) {
                        $data[] = $this->formatData($parItem, 'transferred');
                    } else {
                        $data[] = $this->formatData($parItem, 'issued');
                    }
                }
            } 
            
            // Handle RRSP Items
            elseif (!empty($regPpei->rrppe_id)) {
                $parItem = $regPpei->rrppe; // Access the related ParItem directly
                // dd($parItem);
                if ($parItem && $parItem->par->par_item->status === "Returned") {
                    $data[] = $this->formatData($parItem, 'returned');
                } elseif ($parItem && $parItem->par->par_item->status === "Disposed") {
                    $data[] = $this->formatData($parItem, 'disposed');
                }
            }
        }
        
        return view('supply.print.regppei', compact('data', 'hope', 'supply_officer', 'type'));   
    }

    // Helper function to format data
    private function formatData($item, $type)
    {
        return match ($type) {
            'issued' => [
                'id' => $item->id,
                'date' => $item->par?->date,
                'reference' => $item->par?->par_no,
                'property_no' => $item->property_no,
                'description' => $item->description,
                'specific_type' => $item->specific_type,
                'date_acquired' => $item->date_acquired,
                'issued_qty' => $item->quantity,
                'issued_office' => $item->par?->entity_name . '<br>' . $item->par?->recipient,
                'transferred_qty' => "",
                'transferred_office' => "",
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->property_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->amount)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'transferred' => [
                'id' => $item->id,
                'date' => $item->par?->date,
                'reference' => $item->par?->par_no,
                'property_no' => $item->property_no,
                'description' => $item->description,
                'specific_type' => $item->specific_type,
                'date_acquired' => $item->date_acquired,
                'issued_qty' => "",
                'issued_office' => "",
                'transferred_qty' => $item->quantity,
                'transferred_office' => $item->par?->entity_name . '<br>' . $item->par?->recipient,
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->property_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->amount)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'returned' => [
                'id' => $item->id,
                'date' => $item->date,
                'reference' => $item->rrppe_no,
                'property_no' => $item->par->par_item->property_no,
                'description' => $item->par->par_item->description,
                'specific_type' => $item->par->par_item->specific_type,
                'date_acquired' => $item->par->par_item->date_acquired,
                'issued_qty' => "",
                'issued_office' => "",
                'returned_qty' => $item->par->par_item?->quantity,
                'returned_office' => $item->par?->entity_name . "/"."," . $item->par?->recipient,
                'transferred_qty' => "",
                'transferred_office' => "",
                'disposed_qty' => "",
                'balance_qty' => $item->par->par_item->property_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->par->par_item->amount)) * floatval($item->par->par_item->quantity),
                'remarks' => $item->par->par_item->remarks,
            ],
            'disposed' => [
                'id' => $item->id,
                'date' => $item->rrppe?->date,
                'reference' => $item->rrppe?->rrppe_no,
                'property_no' => $item->property_no,
                'description' => $item->description,
                'specific_type' => $item->specific_type,
                'date_acquired' => $item->date_acquired,
                'issued_qty' => "",
                'issued_office' => "",
                'returned_qty' => $item->quantity,
                'returned_office' => $item->rrppe?->entity_name . '<br>' . $item->rrppe?->recipient,
                'transferred_qty' => "",
                'transferred_office' => "",
                'disposed_qty' => "",
                'balance_qty' => $item->property_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->amount)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            default => [],
        };
    }
}