<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\IcsLv;
use App\Models\IcsItemLv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
 
class SpLvRecipientController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('recipient_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('supply.semi_expendable_lv_recipient.index');
    }

    public function getSpLvRecipients(Request $request)
    {                     
        $data = IcsLv::select('id', 'recipient', 'designation', 'entity_name')
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('ics_lvs')
                        ->groupBy('recipient');
                })
                ->orderBy('recipient', 'asc')
                ->get();

        return datatables($data)->make(true);   
    }

    public function show($id)
    {
        $data = IcsLv::findOrfail($id); 
    
;        return view('supply.semi_expendable_lv_recipient.show', compact('data'));
    }

    public function getSpLvRecipientItems(Request $request)
    {              
        $recipient = $request->recipient;
        $ics_data = IcsLv::where('recipient', $recipient)->get();
        $data = [];
        foreach($ics_data as $ics_datum){
            $ics_id = $ics_datum->id;
            $ics_items = IcsItemLv::with('ics_lv')->where('ics_lv_id', $ics_id)->get();
            foreach($ics_items as $ics_item) {
                $data[] = [
                    'id' => $ics_item->id,
                    'date' => $ics_item->ics_lv->date,
                    'ics_lv_no' => $ics_item->ics_lv->ics_lv_no,
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
