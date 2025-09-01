<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIirupRequest;
use App\Http\Requests\StoreIirupRequest;
use App\Http\Requests\UpdateIirupRequest;
use App\Models\Iirup;
use App\Models\Rpcppe;
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

class IirupController extends Controller
{
    public function index() 
    {
        abort_if(Gate::denies('iirup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.iirup.index');
    }

    public function getIirups(Request $request)
    {   
        $data = Iirup::orderBy('id', 'asc')->get();

        return datatables($data)->make(true);   
    }
    
    public function create(Request $request)
    {
        abort_if(Gate::denies('iirup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $stations = Station::orderBy('station_name', 'asc')->get();
        $employees = DavnorsysEmployee::select('fullname')->orderBy('fullname', 'asc')->get();
        $positions = Position::orderBy('position', 'asc')->get();

        return view('supply.iirup.create', compact('stations', 'employees', 'positions'));
    }

    public function store(StoreIirupRequest $request)
    {
        abort_if(Gate::denies('iirup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
    
        $iirup = Iirup::create($data);

        return redirect()->route('supply.iirup.index');
    }

    public function createFromRpcppe(Request $request)
    {
        abort_if(Gate::denies('iirup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $stations = Station::orderBy('station_name', 'asc')->get();
        $employees = DavnorsysEmployee::select('fullname')->orderBy('fullname', 'asc')->get();
       
        return view('supply.iirup.create_from_rpcppe', compact('stations', 'employees'));
    }

    public function storeFromRpcppe(StoreIirupRequest $request)
    {
        abort_if(Gate::denies('iirup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
    
        $iirup = Iirup::create($data);

        return redirect()->route('supply.iirup.index');
    }   

    public function edit(Iirup $iirup)
    {
        abort_if(Gate::denies('iirup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $employees = DavnorsysEmployee::select('fullname')->orderBy('fullname', 'asc')->get();
        $positions = Position::orderBy('position', 'asc')->get();

        return view('supply.iirup.edit', compact('iirup', 'employees', 'positions'));
    }

    public function update(UpdateIirupRequest $request, Iirup $iirup)
    {
        abort_if(Gate::denies('iirup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $iirup->update($request->all());

        return redirect()->route('supply.iirup.index');
    }

    public function show(Iirup $iirup)
    {
        abort_if(Gate::denies('iirup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.iirup.show', compact('iirup'));
    }

    public function destroy(Iirup $iirup)
    {
        abort_if(Gate::denies('iirup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $iirup->delete();

        return back();
    }
}
