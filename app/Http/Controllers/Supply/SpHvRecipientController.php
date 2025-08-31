<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\IcsHv;
use App\Models\IcsItemHv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
 
class SpHvRecipientController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('recipient_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('supply.semi_expendable_hv_recipient.index');
    }

    public function getSpHvRecipients(Request $request)
    {                     
        $data = IcsHv::select('id', 'recipient', 'designation', 'entity_name')
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('ics_hvs')
                        ->groupBy('recipient');
                })
                ->orderBy('recipient', 'asc')
                ->get();

        return datatables($data)->make(true);   
    }

    public function show($id)
    {
        $data = IcsHv::findOrfail($id); 
    
;        return view('supply.semi_expendable_hv_recipient.show', compact('data'));
    }

    public function getSpHvRecipientItems(Request $request)
    {              
        $recipient = $request->recipient;
        $ics_data = IcsHv::where('recipient', $recipient)->get();
        $data = [];
        foreach($ics_data as $ics_datum){
            $ics_id = $ics_datum->id;
            $ics_items = IcsItemHv::with('ics_hv')->where('ics_hv_id', $ics_id)->get();
            foreach($ics_items as $ics_item) {
                $data[] = [
                    'id' => $ics_item->id,
                    'date' => $ics_item->ics_hv->date,
                    'ics_hv_no' => $ics_item->ics_hv->ics_hv_no,
                    'quantity' => $ics_item->quantity,
                    'unit' => $ics_item->unit,
                    'unit_cost' => $ics_item->unit_cost,
                    'total_cost' => $ics_item->total_cost,
                    'description' => $ics_item->description,
                    'inventory_item_no' => $ics_item->inventory_item_no, 
                    'lifespan' => $ics_item->lifespan,
                    'serial_no' => $ics_item->serial_no,
                    'type' => $ics_item->type,
                    'remarks' => $ics_item->remarks
                ];
            }            
        }
        return datatables($data)->make(true);   
    }
}
