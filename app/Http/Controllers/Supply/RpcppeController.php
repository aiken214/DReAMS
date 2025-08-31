<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRpcppeRequest;
use App\Http\Requests\StoreRpcppeRequest;
use App\Http\Requests\UpdateRpcppeRequest;
use App\Models\Rpcppe;
use App\Models\Unit;
use App\Models\Station;
use App\Models\User;
use App\Models\DavnorsysEmployee;
use App\Models\Position;
use App\Models\ParItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RpcppeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rpcppe_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.rpcppe.index');
    }

    public function getRpcppe(Request $request)
    {            
        // Fetch data
        $start_date = $request->get('from');
        $end_date = $request->get('to');

        // Initialize query
        $query = Rpcppe::whereNull('iirup_item_id');
        
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }

        if ($request->filled('type')) {
            $query->where('specific_type', $request->type);
        }

        $data = $query->get();

        $totalCost = $query->sum('unit_value'); // Calculate total cost
        // Use DataTables with the query
        return datatables($data)
            ->with('totalCost', $totalCost) // Add totalCost to the response
            ->make(true);   
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('rpcppe_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $stations = Station::select('id', 'station_name')->orderBy('station_name', 'asc')->get();
        $id = $request->id;    
        $units = Unit::all()->sortBy('unit');

        return view('supply.rpcppe.create', compact('id', 'units', 'stations'));
    }

    public function store(StoreRpcppeRequest $request)
    {
        $station = Station::where('id', $request->station_id)->first();

        if (!$station) {
            return back()->withErrors(['station' => 'Station not found.']);
        }
        $data = $request->all();
        $data['accountable_officer'] = $station->accountable_officer;
        $data['position'] = $station->position;
        $data['remarks'] = $station->station_name. ', ' .$request->remarks;
        
        $rpcppe = Rpcppe::create($data);

        return redirect()->route('supply.rpcppe.index');
    }

    public function createFromPar(Request $request)
    { 
        abort_if(Gate::denies('rpcppe_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $id = $request->id;
        $parItems = ParItem::with('par')->whereNull('rpcppe_id')->get(); 

        return view('supply.rpcppe.create_from_par_item', compact('id', 'parItems'));
    }

    public function storeFromPar(StoreRpcppeRequest $request)
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

        $rpcppe = Rpcppe::create($data);
        ParItem::where('id', $rpcppe->par_item_id)->update(['rpcppe_id' => $rpcppe->id]); 

        return redirect()->route('supply.rpcppe.index');
    }

    public function edit(Rpcppe $rpcppe)
    {
        abort_if(Gate::denies('rpcppe_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
    
        $units = Unit::all()->sortBy('unit');
        $employees = DavnorsysEmployee::select('fullname')->orderBy('fullname', 'asc')->get();
        $positions = Position::select('position')->orderBy('position', 'asc')->get();

        return view('supply.rpcppe.edit', compact('rpcppe', 'units', 'employees', 'positions'));
    }

    public function update(UpdateRpcppeRequest $request, Rpcppe $rpcppe)
    {
        $rpcppe->update($request->all());

        return redirect()->route('supply.rpcppe.index');
    }

    public function show(Rpcppe $rpcppe)
    {
        abort_if(Gate::denies('rpcppe_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $station = Station::where('id', $rpcppe->station_id)->value('station_name');

        return view('supply.rpcppe.show', compact('rpcppe', 'station'));
    }

    public function destroy(Rpcppe $rpcppe, $id)
    {
        abort_if(Gate::denies('rpcppe_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rpcppe = Rpcppe::find($id);
        $rpcppe->delete();

        return back();
    }
}
