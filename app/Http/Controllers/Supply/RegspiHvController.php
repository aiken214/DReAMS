<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\RegspiHv;
use App\Models\IcsHv;
use App\Models\IcsItemHv;
use App\Models\RrspHv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RegspiHvController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('regspi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('supply.regspi_hv.index');
    }

    public function getRegspiHv(Request $request)
    {          
        // Fetch data
        $start_date = $request->get('from');
        $end_date = $request->get('to');

        $query = RegspiHv::with([
            'ics_hv:id,entity_name,recipient',
            'ics_hv.ics_item_hv:id,ics_hv_id,semi_expendable_card_id,inventory_item_no,description,type,lifespan,quantity,unit_cost,status,remarks', 
            'ics_hv.ics_item_hv.semi_expendable_card:id,balance_quantity', 
            'rrsp_hv:id,ics_hv_id,date,rrsp_hv_no',
            'rrsp_hv.ics_hv:id,entity_name,recipient',
            'rrsp_hv.ics_hv.ics_item_hv:id,ics_hv_id,semi_expendable_card_id,inventory_item_no,description,type,lifespan,quantity,unit_cost,status,remarks', 
            'rrsp_hv.ics_hv.ics_item_hv.semi_expendable_card:id,balance_quantity', 
        ])->orderBy('date', 'desc')->orderBy('id', 'desc'); // No `get()` here        

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [Carbon::parse($start_date)->format('Y-m-d')])
                  ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [Carbon::parse($end_date)->format('Y-m-d')]);
        }

        if ($request->filled('type')) {
            $query->whereHas('ics_hv.ics_item_hv', function ($q) use ($request) {
                $q->where('type', $request->type);
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
                    if (($icsItem->ics_hv->status === 'Re-issued')) {
                        $data[] = $this->formatData($icsItem, 'reissued');
                    } else {
                        $data[] = $this->formatData($icsItem, 'issued');
                    }
                }
            } 
            
            // Handle RRSP Items
            elseif (!empty($regSpi->rrsp_hv_id)) {
                $icsItem = $regSpi->rrsp_hv; // Access the related IcsItemHv directly
              
                if ($icsItem && $icsItem->ics_hv->ics_item_hv->status === "Returned") {
                    $data[] = $this->formatData($icsItem, 'returned');
                } elseif ($icsItem && $icsItem->ics_hv->ics_item_hv->status === "Disposed") {
                    $data[] = $this->formatData($icsItem, 'disposed');
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
                'date' => $item->ics_hv?->date,
                'reference' => $item->ics_hv?->ics_hv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => $item->quantity,
                'issued_office' => $item->ics_hv?->entity_name . "/"."," . $item->ics_hv?->recipient,
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
                'date' => $item->ics_hv?->date, // Fixed field
                'reference' => $item->ics_hv?->ics_hv_no,
                'property_no' => $item->inventory_item_no,
                'description' => $item->description,
                'type' => $item->type,
                'lifespan' => $item->lifespan,
                'issued_qty' => "",
                'issued_office' => "",
                're-issued_qty' => $item->quantity,
                're-issued_office' => $item->ics_hv?->entity_name . "/"."," . $item->ics_hv?->recipient,
                'returned_qty' => "",
                'returned_office' => "",                        
                'disposed_qty' => "",
                'balance_qty' => $item->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval($item->unit_cost) * floatval($item->quantity),
                'remarks' => $item->remarks,
            ],
            'returned' => [
                'id' => $item->id,
                'date' => $item->date,
                'reference' => $item->rrsp_hv_no,
                'property_no' => $item->ics_hv->ics_item_hv->inventory_item_no,
                'description' => $item->ics_hv->ics_item_hv->description,
                'type' => $item->type,
                'lifespan' => $item->ics_hv->ics_item_hv->lifespan,
                'issued_qty' => "",
                'issued_office' => "",
                'returned_qty' => $item->ics_hv->ics_item_hv->quantity,
                'returned_office' => $item->ics_hv?->entity_name . "/". "," . $item->ics_hv?->recipient,
                're-issued_qty' => "",
                're-issued_office' => "",
                'disposed_qty' => "",
                'balance_qty' => $item->ics_hv->ics_item_hv->semi_expendable_card?->balance_quantity ?? '',
                'amount' => floatval($item->ics_hv->ics_item_hv->unit_cost) * floatval($item->quantity),
                'remarks' => $item->ics_hv->ics_item_hv->remarks,
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
                'returned_office' => $item->rrsp_hv?->entity_name . "/"."," . $item->rrsp_hv?->recipient,
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