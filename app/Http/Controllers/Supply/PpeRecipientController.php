<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\Par;
use App\Models\ParItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class PpeRecipientController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('recipient_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('supply.property_recipient.index');
    }

    public function getPpeRecipients(Request $request)
    {                     
        $data = Par::select('id', 'recipient', 'designation', 'entity_name')
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('pars')
                        ->groupBy('recipient');
                })
                ->orderBy('recipient', 'asc')
                ->get();

        return datatables($data)->make(true);   
    }

    public function show($id)
    {
        $data = Par::findOrfail($id); 
        
        return view('supply.property_recipient.show', compact('data'));
    }

    public function getPpeRecipientItems(Request $request)
    {              
        $recipient = $request->recipient;
        $par_data = Par::where('recipient', $recipient)->get();
        $data = [];
        foreach($par_data as $par_datum){
            $par_id = $par_datum->id;
            $par_items = ParItem::with('par')->where('par_id', $par_id)->get();
            foreach($par_items as $par_item) {
                $data[] = [
                    'id' => $par_item->id,
                    'date' => $par_item->par->date,
                    'par_no' => $par_item->par->par_no,
                    'quantity' => $par_item->quantity,
                    'unit' => $par_item->unit,
                    'amount' => $par_item->amount,
                    'description' => $par_item->description,
                    'property_no' => $par_item->property_no, 
                    'date_acquired' => $par_item->date_acquired,
                    'serial_no' => $par_item->serial_no,
                    'type' => $par_item->type,
                    'remarks' => $par_item->remarks
                ];
            }            
        }
        return datatables($data)->make(true);   
    }
}
