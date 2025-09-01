<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIiruspRequest;
use App\Http\Requests\StoreIiruspRequest;
use App\Http\Requests\UpdateIiruspRequest;
use App\Models\Iirusp;
use App\Models\Rpcsp;
use App\Models\Unit;
use App\Models\Station;
use App\Models\User;
use App\Models\DavnorsysEmployee;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class IiruspController extends Controller
{
    public function index() 
    {
        abort_if(Gate::denies('iirusp_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.iirusp.index');
    }

    public function getIirusps(Request $request)
    {  
        $data = Iirusp::orderBy('id', 'asc')->get();

        return datatables($data)->make(true);   
    }
    
    public function create(Request $request)
    {
        abort_if(Gate::denies('iirusp_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $stations = Station::orderBy('station_name', 'asc')->get();
        $employees = DavnorsysEmployee::select('fullname')->orderBy('fullname', 'asc')->get();
        $positions = Position::orderBy('position', 'asc')->get();
      
        return view('supply.iirusp.create', compact('stations', 'employees', 'positions'));
    }

    public function store(StoreIiruspRequest $request)
    {
        abort_if(Gate::denies('iirusp_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
   
        $iirusp = Iirusp::create($data);

        return redirect()->route('supply.iirusp.index');
    }

    public function createFromRpcsp(Request $request)
    {
        abort_if(Gate::denies('iirusp_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $stations = Station::orderBy('station_name', 'asc')->get();
        $employees = DavnorsysEmployee::select('fullname')->orderBy('fullname', 'asc')->get();
       
        return view('supply.iirusp.create_from_rpcsp', compact('stations', 'employees'));
    }

    public function storeFromRpcsp(StoreIiruspRequest $request)
    {
        abort_if(Gate::denies('iirusp_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
    
        $iirup = Iirusp::create($data);

        return redirect()->route('supply.iirusp.index');
    }   

    public function edit(Iirusp $iirusp)
    {
        abort_if(Gate::denies('iirusp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $employees = DavnorsysEmployee::select('fullname')->orderBy('fullname', 'asc')->get();
        $positions = Position::orderBy('position', 'asc')->get();

        return view('supply.iirusp.edit', compact('iirusp', 'employees', 'positions'));
    }

    public function update(UpdateIiruspRequest $request, Iirusp $iirusp)
    {
        abort_if(Gate::denies('iirusp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $iirusp->update($request->all());

        return redirect()->route('supply.iirusp.index');
    }

    public function show(Iirusp $iirusp)
    {
        abort_if(Gate::denies('iirusp_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.iirusp.show', compact('iirusp'));
    }

    public function destroy(Iirusp $iirusp)
    {
        abort_if(Gate::denies('iirusp_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $iirusp->delete();

        return back();
    }
}
