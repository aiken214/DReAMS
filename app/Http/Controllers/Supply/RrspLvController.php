<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRrspLvRequest;
use App\Http\Requests\StoreRrspLvRequest;
use App\Http\Requests\UpdateRrspLvRequest;
use App\Models\RrspLv;
use App\Models\IcsLv;
use App\Models\IcsItemLv;
use App\Models\RegspiLv;
use App\Models\SemiExpendableCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RrspLvController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rrsp_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
      
        return view('supply.rrsp_lv.index');
    }

    public function getRrspLv(Request $request)
    {            
        // Fetch data
        $data = RrspLv::with([
            'ics_lv:id,ics_lv_no,entity_name,recipient,designation',
            'ics_lv.ics_item_lv:id,ics_lv_id,remarks'
            ])
            ->orderBy('id', 'asc')->get();

        // Use DataTables with the query
        return datatables($data)->make(true);   
    }

    public function create()
    {
        abort_if(Gate::denies('rrsp_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $icsLvs = IcsLv::with(['ics_item_lv' => function ($query) {
            $query->where('status', 'Issued')
                  ->orWhereNull('status'); // Include items with NULL status
        }])
        ->whereHas('ics_item_lv', function ($query) {
            $query->where('status', 'Issued')
                  ->orWhereNull('status');
        })
        ->get();

        return view('supply.rrsp_lv.create', compact('icsLvs'));
    }

    public function store(StoreRrspLvRequest $request)
    {
        $ics_lv_id = $request->ics_lv_id;
        $data = $request->all();
        $data['rrsp_lv_no'] =  $this->generateRrspNo();       

        $rrsp = RrspLv::create($data);

        //save rspi
        $regSpiData = [
            'date' => $rrsp->date, 
            'reference' => $rrsp->rrsp_lv_no,                     
            'rrsp_lv_id' => $rrsp->id, 
            ];
        RegspiLv::create($regSpiData);

        return redirect()->route('supply.rrsp_lv.index');
    }
    
    private function generateRrspNo()
    {
        $last_rrsp = RrspLv::where('rrsp_lv_no', 'like', 'RRSPLV%')->orderByDesc('rrsp_lv_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'RRSPLV';

        if (!$last_rrsp || !$last_rrsp->rrsp_lv_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_rrsp->rrsp_lv_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }

    public function edit(RrspLv $rrspLv)
    {
        abort_if(Gate::denies('rrsp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        // Eager load the relationships on the single $rrspLv instance
        $rrspLv->load([
            'ics_lv:id,ics_lv_no,entity_name,recipient,designation',
            'ics_lv.ics_item_lv:id,ics_lv_id,serviceability,remarks'
        ]);

        return view('supply.rrsp_lv.edit', compact('rrspLv'));
    }

    public function update(UpdateRrspLvRequest $request, RrspLv $rrspLv)
    {
    
        $rrspLv->update($request->all());

        return redirect()->route('supply.rrsp_lv.index');
    } 
    
    public function show(RrspLv $rrspLv)
    {
        abort_if(Gate::denies('rrsp_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.rrsp_lv.show', compact('rrspLv'));
    }  
    
    public function destroy(RrspLv $rrspLv)
    {
        abort_if(Gate::denies('rrsp_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Get the single IcsItemLv record
        $rrspItemLvs = RrspItemLv::where('rrsp_lv_id', $rrspLv->id)->get();

        foreach ($rrspItemLvs as $item) {
            $icsItemLv = IcsItemLv::where('id', $item->ics_item_lv_id)->first();

            if ($icsItemLv) {
                // Reset its fields
                $icsItemLv->update([
                    'status'         => null,
                    'serviceability' => null,
                    'remarks'        => null,
                ]);

                // Update the related SemiExpendableCard
                if ($icsItemLv->semi_expendable_card_id) {
                    $semiExpendableCard = SemiExpendableCard::find($icsItemLv->semi_expendable_card_id);

                    if ($semiExpendableCard) {
                        $semiExpendableCard->issued_quantity = max(0, $semiExpendableCard->issued_quantity + $item->quantity);
                        $semiExpendableCard->balance_quantity = max(0, $semiExpendableCard->balance_quantity - $item->quantity);
                        $semiExpendableCard->save();
                    }
                }
            }
        }

        $rrspLv->delete();

        return back();
    }

}
