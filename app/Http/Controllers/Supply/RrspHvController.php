<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRrspHvRequest;
use App\Http\Requests\StoreRrspHvRequest;
use App\Http\Requests\UpdateRrspHvRequest;
use App\Models\RrspHv;
use App\Models\IcsHv;
use App\Models\IcsItemHv;
use App\Models\RegspiHv;
use App\Models\SemiExpendableCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RrspHvController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rrsp_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.rrsp_hv.index');
    }

    public function getRrspHv(Request $request)
    {            
        // Fetch data
        $data = RrspHv::with([
            'ics_hv:id,ics_hv_no,entity_name,recipient,designation',
            'ics_hv.ics_item_hv:id,ics_hv_id,remarks'
            ])
            ->orderBy('id', 'asc')->get();

        // Use DataTables with the query
        return datatables($data)->make(true);   
    }

    public function create()
    {
        abort_if(Gate::denies('rrsp_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $icsHvs = IcsHv::with(['ics_item_hv' => function ($query) {
            $query->where('status', 'Issued')
                  ->orWhereNull('status'); // Include items with NULL status
        }])
        ->whereHas('ics_item_hv', function ($query) {
            $query->where('status', 'Issued')
                  ->orWhereNull('status');
        })
        ->get();

        return view('supply.rrsp_hv.create', compact('icsHvs'));
    }

    public function store(StoreRrspHvRequest $request)
    {
        $ics_hv_id = $request->ics_hv_id;
        $data = $request->all();
        $data['rrsp_hv_no'] =  $this->generateRrspNo();       

        IcsHv::where('id', $ics_hv_id)->update(['status' => "Returned"]);
        IcsItemHv::where('ics_hv_id', $ics_hv_id)->update([
            'status' => "Returned",
            'serviceability' => $request->serviceability,
            'remarks' => "Item returned on {$request->date}",
        ]); 
        $icsItem = IcsItemHv::where('ics_hv_id', $ics_hv_id)->first();
        SemiExpendableCard::where('id', $icsItem->semi_expendable_card_id)->update([
            'balance_quantity' => DB::raw("balance_quantity + {$icsItem->quantity}"),
            'issued_quantity' => DB::raw("issued_quantity - {$icsItem->quantity}"),
        ]);
        
        $rrsp = RrspHv::create($data);

        //save rspi
        $regSpiData = [
            'date' => $rrsp->date, 
            'reference' => $rrsp->rrsp_hv_no,                     
            'rrsp_hv_id' => $rrsp->id, 
            ];
        RegspiHv::create($regSpiData);

        return redirect()->route('supply.rrsp_hv.index');
    }
    
    private function generateRrspNo()
    {
        $last_rrsp = RrspHv::where('rrsp_hv_no', 'like', 'RRSPHV%')->orderByDesc('rrsp_hv_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'RRSPHV';

        if (!$last_rrsp || !$last_rrsp->rrsp_hv_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_rrsp->rrsp_hv_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }

    public function edit(RrspHv $rrspHv)
    {
        abort_if(Gate::denies('rrsp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        // Eager load the relationships on the single $rrspHv instance
        $rrspHv->load([
            'ics_hv:id,ics_hv_no,entity_name,recipient,designation',
            'ics_hv.ics_item_hv:id,ics_hv_id,serviceability,remarks'
        ]);

        return view('supply.rrsp_hv.edit', compact('rrspHv'));
    }

    public function update(UpdateRrspHvRequest $request, RrspHv $rrspHv)
    {
        $ics_hv_id = $rrspHv->ics_hv_id;        
        IcsItemHv::where('ics_hv_id', $ics_hv_id)->update([
            'serviceability' => $request->serviceability,
        ]); 

        $rrspHv->update($request->all());

        return redirect()->route('supply.rrsp_hv.index');
    }   
    
    public function show(RrspHv $rrspHv)
    {
        abort_if(Gate::denies('rrsp_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $rrspHv->load('ics_hv');

        return view('supply.rrsp_hv.show', compact('rrspHv'));
    }  

    public function destroy(RrspHv $rrspHv)
    {
        abort_if(Gate::denies('rrsp_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ics_hv_id = $rrspHv->ics_hv_id;        
        IcsItemHv::where('ics_hv_id', $ics_hv_id)->update([
            'status' => null,
            'serviceability' => null,
        ]); 

        $rrspHv->delete();

        return back();
    }

}
