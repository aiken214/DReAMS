<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\Regppei;
use App\Models\Par;
use App\Models\ParItem;
use App\Models\Rrppe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RegppeiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('regppei_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
   
        return view('supply.regppei.index');
    }

    public function getRegppei(Request $request)
    {          
        // Fetch data
        $start_date = $request->get('from');
        $end_date = $request->get('to');

        $query = Regppei::with([
            'par:id,entity_name,recipient',
            'par.par_item:id,par_id,property_card_id,property_no,description,specific_type,date_acquired,quantity,amount,status,remarks', 
            'par.par_item.property_card:id,balance_quantity', 
            'rrppe:id,par_id,date,rrppe_no',
            'rrppe.par:id,entity_name,recipient',
            'rrppe.par.par_item:id,par_id,property_card_id,property_no,description,specific_type,date_acquired,quantity,amount,status,remarks', 
            'rrppe.par.par_item.property_card:id,balance_quantity', 
        ])->orderBy('date', 'desc')->orderBy('id', 'desc'); // No `get()` here        

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [Carbon::parse($start_date)->format('Y-m-d')])
                  ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [Carbon::parse($end_date)->format('Y-m-d')]);
        }

        if ($request->filled('type')) {
            $query->whereHas('par.par_item', function ($q) use ($request) {
                $q->where('specific_type', $request->type);
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

        return datatables($data)->make(true);        
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
                'issued_office' => $item->par?->entity_name . "/"."," . $item->par?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->property_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->amount)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'transferred' => [
                'id' => $item->id,
                'date' => $item->par?->date, // Fixed field
                'reference' => $item->par?->par_no,
                'property_no' => $item->property_no,
                'description' => $item->description,
                'specific_type' => $item->specific_type,
                'date_acquired' => $item->date_acquired,
                'issued_qty' => "",
                'issued_office' => "",
                're-issued_qty' => $item->quantity,
                're-issued_office' => $item->par?->entity_name . "/"."," . $item->par?->recipient,
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->property_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->unit_cost)) * floatval($item->quantity),
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
                'returned_qty' => $item->par->par_item->quantity,
                'returned_office' => $item->par?->entity_name . "/"."," . $item->par?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
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
                'returned_office' => $item->rrppe?->entity_name . "/"."," . $item->rrppe?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'disposed_qty' => "",
                'balance_qty' => $item->property_card?->balance_quantity ?? '',
                'amount' => floatval(str_replace(',', '', $item->unit_cost)) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            default => [],
        };
    }
}