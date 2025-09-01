<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIcsLvRequest;
use App\Http\Requests\StoreIcsLvRequest;
use App\Http\Requests\UpdateIcsLvRequest;
use App\Models\IcsLv;
use App\Models\IcsItemLv;
use App\Models\Ris;
use App\Models\RisItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class IcsLvController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ics_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.ics_lv.index');
    }

    public function getIcsLv(Request $request)
    {            
        // Fetch data
        $data = IcsLv::with(['ris:id,ris_no'])
            ->orderBy('id', 'asc')->get();

        // Use DataTables with the query
        return datatables($data)
            ->editColumn('reference', function ($row) {
                return $row->ris->ris_no;
            })
            ->make(true);   
    }

    public function create()
    {
        abort_if(Gate::denies('ics_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $risData = Ris::whereHas('ris_item', function ($query) {
                $query->where('category', 'LVSE')
                    ->whereNull('status');
            })
            ->with('ris_item') // Load related ris_item after filtering
            ->get();

        return view('supply.ics_lv.create', compact('risData'));
    }

    public function store(StoreIcsLvRequest $request)
    {
        abort_if(Gate::denies('ics_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->ris_id;

        // Get RIS items under the given RIS ID with category HVSE
        $risItems = RisItem::where('ris_id', $id)
            ->where('category', 'LVSE')
            ->with(['semi_expendables:id,unit_price,amount']) // Select only id and unit_price
            ->get();

        // Check if RIS items exist
        if ($risItems->isEmpty()) {
            return redirect()->back()->with('error', 'No LVSE items found for this RIS.');
        }

        $data = $request->all();
        $data['ics_lv_no'] = $this->generateIcsNo();

        // Create ICS HV Entry
        $icslv = IcsLv::create($data);

        foreach ($risItems as $item) {
            for ($i = 0; $i < $item->issued_quantity; $i++) {  
    
                $icsItemLv  = new IcsItemLv;
                $icsItemLv->quantity = $item->issued_quantity;            
                $icsItemLv->unit = $item->unit;
                $icsItemLv->unit_cost = $item->semi_expendables?->unit_price;
                $icsItemLv->total_cost = $item->semi_expendables?->amount;
                $icsItemLv->description = $item->description;
                $icsItemLv->ris_item_id = $item->id;
                $icsItemLv->ics_lv_id = $icslv->id;
                $icsItemLv->semi_expendable_card_id = $item->semi_expendable_card_id;
                $icsItemLv->save();    
    
                // Update RIS Item status
                $item->status = "ICS Generated";
                $item->save();
            }
        }
    
        return redirect()->route('supply.ics_lv.index')->with('success', 'ICS successfully generated.');
    }

    private function generateIcsNo()
    {
        $last_ics = IcsLv::where('ics_lv_no', 'like', 'ICSLV%')->orderByDesc('ics_lv_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'ICSLV';

        if (!$last_ics || !$last_ics->ics_lv_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_ics->ics_lv_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }  

    public function edit(IcsLv $icsLv)
    {
        abort_if(Gate::denies('ics_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.ics_lv.edit', compact('icsLv'));
    }

    public function update(UpdateIcsLvRequest $request, IcsLv $icsLv)
    {
        abort_if(Gate::denies('ics_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $icsLv->update($request->all());

        return redirect()->route('supply.ics_lv.index');
    }  

    public function show(IcsLv $icsLv)
    {
        abort_if(Gate::denies('ics_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $icsLv->load([
            'ris:id,ris_no', 
        ]);

        return view('supply.ics_lv.show', compact('icsLv'));
    }  
}
