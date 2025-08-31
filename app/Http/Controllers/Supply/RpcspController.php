<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRpcspRequest;
use App\Http\Requests\StoreRpcspRequest;
use App\Http\Requests\UpdateRpcspRequest;
use App\Models\Rpcsp;
use App\Models\Unit;
use App\Models\Station;
use App\Models\User;
use App\Models\DavnorsysEmployee;
use App\Models\Position;
use App\Models\IcsItemHv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RpcspController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rpcsp_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.rpcsp.index');
    }

    public function getRpcsp(Request $request)
    {            
        // Fetch data
        $start_date = $request->get('from');
        $end_date = $request->get('to');

        // Initialize query
        $query = Rpcsp::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
      
        $data = $query->get();

        $totalCost = $data->sum(function ($item) {
            // Remove commas and cast to float
            return floatval(str_replace(',', '', $item->unit_value));
        });
        // Use DataTables with the query
        return datatables($data)
            ->with('totalCost', $totalCost) // Add totalCost to the response
            ->make(true);      
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('rpcsp_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;    
        $units = Unit::all()->sortBy('unit');

        return view('supply.rpcsp.create', compact('id', 'units'));
    }

    public function store(StoreRpcspRequest $request)
    {
        $data = $request->all();
        
        $rpcsp = Rpcsp::create($data);

        return redirect()->route('supply.rpcsp.index');
    }
    public function createFromIcsHv(Request $request)
    { 
        abort_if(Gate::denies('rpcsp_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $id = $request->id;
        $icsItems = IcsItemHv::with('ics_hv')->whereNull('rpcsp_id')->get(); 

        return view('supply.rpcsp.create_from_ics_item_hv', compact('id', 'icsItems'));
    }

    public function storeFromIcsHv(StoreRpcspRequest $request)
    {    
        $station = Station::where('station_name', $request->station)->first();

        if (!$station) {
            return back()->withErrors(['station' => 'Station not found.']);
        }

        $data = $request->all(); 
        $data['station_id'] = $station->id;
        $data['accountable_officer'] = $station->accountable_officer;
        $data['position'] = $station->position;
        $data['remarks'] = $station->station_name. ', ' .$request->remarks;

        $rpcsp = Rpcsp::create($data);
        IcsItemHv::where('id', $rpcsp->ics_item_hv_id)->update(['rpcsp_id' => $rpcsp->id]); 

        return redirect()->route('supply.rpcsp.index');
    }
    public function edit(Rpcsp $rpcsp)
    {
        abort_if(Gate::denies('rpcsp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
    
        $units = Unit::all()->sortBy('unit');

        return view('supply.rpcsp.edit', compact('rpcsp', 'units'));
    }

    public function update(UpdateRpcspRequest $request, Rpcsp $rpcsp)
    {
        $rpcsp->update($request->all());

        return redirect()->route('supply.rpcsp.index');
    }

    public function show(Rpcsp $rpcsp)
    {
        abort_if(Gate::denies('rpcsp_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.rpcsp.show', compact('rpcsp'));
    }

    public function destroy(Rpcsp $rpcsp, $id)
    {
        abort_if(Gate::denies('rpcsp_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rpcsp = Rpcsp::find($id);
        $rpcsp->delete();

        return back();
    }
}
