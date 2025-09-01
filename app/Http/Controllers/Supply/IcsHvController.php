<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIcsHvRequest;
use App\Http\Requests\StoreIcsHvRequest;
use App\Http\Requests\UpdateIcsHvRequest;
use App\Models\IcsHv;
use App\Models\IcsItemHv;
use App\Models\Ris;
use App\Models\RisItem;
use App\Models\SemiExpendableCard;
use App\Models\RegspiHv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class IcsHvController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ics_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.ics_hv.index');
    }

    public function getIcsHv(Request $request)
    {            
        // Fetch data
        $data = IcsHv::with(['ris:id,ris_no'])
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
                $query->where('category', 'HVSE')
                    ->whereNull('status');
            })
            ->with('ris_item') // Load related ris_item after filtering
            ->get();

        return view('supply.ics_hv.create', compact('risData'));
    }

    public function store(StoreIcsHvRequest $request)
    {
        abort_if(Gate::denies('ics_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->ris_id;

        // Get RIS items under the given RIS ID with category HVSE
        $risItems = RisItem::where('ris_id', $id)
            ->where('category', 'HVSE')
            ->with(['ris:id,iar_id','semi_expendables:id,unit_price']) // Select only id and unit_price
            ->get();

        // Check if RIS items exist
        if ($risItems->isEmpty()) {
            return redirect()->back()->with('error', 'No HVSE items found for this RIS.');
        }

        foreach ($risItems as $item) {
            // Ensure issued_quantity is valid
            $issuedQuantity = (int) $item->issued_quantity;
 
            if ($issuedQuantity <= 0) {
                continue; // Skip items with no issued quantity
            }       
            
            for ($i = 0; $i < $issuedQuantity; $i++) {  
                // Create only one ICS HV Entry per RIS
                $data = $request->all();
                $data['ics_hv_no'] = $this->generateIcsNo();
                $icshv = IcsHv::create($data);

                $icsItemHv = new IcsItemHv;
                $icsItemHv->quantity = 1;            
                $icsItemHv->unit = $item->unit;
                $icsItemHv->unit_cost = optional($item->semi_expendables)->unit_price ?? 0;
                $icsItemHv->total_cost = optional($item->semi_expendables)->unit_price ?? 0;
                $icsItemHv->description = $item->description;
                $icsItemHv->ris_item_id = $item->id;
                $icsItemHv->ics_hv_id = $icshv->id;
                $icsItemHv->semi_expendable_card_id = $item->semi_expendable_card_id;
                $icsItemHv->inventory_item_no = $this->generateInvNo();
                $icsItemHv->save();  
                
                // Update semi_expendable_cards where iar_id matches
                //SemiExpendableCard::whereIn('iar_id', [$item->ris->iar_id])->update(['ics_hv_id' => $icshv->id]);
                //Useless hence SemiExpendableCard hasMany IcsHv

                //save rspi
                $regSpiData = [
                    'date' => $icshv->date, 
                    'reference' => $icshv->ics_hv_no,                     
                    'ics_hv_id' => $icshv->id, 
                    ];
                RegspiHv::create($regSpiData);
            }
        
            // Update RIS Item status
            $item->status = "ICS Generated";
            $item->save();
        }

        return redirect()->route('supply.ics_hv.index')->with('success', 'ICS successfully generated.');
    }
    
    private function generateIcsNo()
    {
        $last_ics = IcsHv::where('ics_hv_no', 'like', 'ICSHV%')->orderByDesc('ics_hv_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'ICSHV';

        if (!$last_ics || !$last_ics->ics_hv_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_ics->ics_hv_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }   

    private function generateInvNo()
    {
        $last_inv = IcsItemHv::where('inventory_item_no', 'like', 'INV%')->orderByDesc('inventory_item_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'INV';

        if (!$last_inv || !$last_inv->inventory_item_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_inv->inventory_item_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }    

    public function edit(IcsHv $icsHv)
    {
        abort_if(Gate::denies('ics_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.ics_hv.edit', compact('icsHv'));
    }

    public function update(UpdateIcsHvRequest $request, IcsHv $icsHv)
    {
        abort_if(Gate::denies('ics_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $icsHv->update($request->all());

        return redirect()->route('supply.ics_hv.index');
    }  

    public function show(IcsHv $icsHv)
    {
        abort_if(Gate::denies('ics_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $icsHv->load([
            'ris:id,ris_no', 
        ]);

        return view('supply.ics_hv.show', compact('icsHv'));
    }  
    
    public function destroy(IcsHv $icsHv)
    {
        abort_if(Gate::denies('ics_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $icsHv->delete();

        return back();
    }
}
