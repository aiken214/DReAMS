<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStationRequest;
use App\Http\Requests\StoreStationRequest;
use App\Http\Requests\UpdateStationRequest;
use App\Models\Station;
use App\Models\DavnorsysEmployee;
use App\Models\Position;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StationController extends Controller
{
    use CsvImportTrait; 

    public function index()
    {
        abort_if(Gate::denies('station_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('admin.station.index');
    }

    public function getStations(Request $request)
    {                
        $data = Station::all()->sortBy('office');
        
        return datatables($data)->make(true);   

    }

    public function create()
    {
        abort_if(Gate::denies('station_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = DavnorsysEmployee::select('fullname')->orderBy('fullname', 'asc')->get();
        $positions = Position::select('position')->orderBy('position', 'asc')->get();
        
        return view('admin.station.create', compact('users', 'positions'));
    }

    public function store(StoreStationRequest $request)
    {

        $station = Station::create($request->all());

        return redirect()->route('admin.station.index');
    }

    public function edit(Station $station)
    {
        abort_if(Gate::denies('station_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $users = DavnorsysEmployee::select('fullname')->orderBy('fullname', 'asc')->get();
        $positions = Position::select('position')->orderBy('position', 'asc')->get();
        
        return view('admin.station.edit', compact('station', 'users', 'positions'));
    }

    public function update(UpdateStationRequest $request, Station $station)
    {
       
        $station->update($request->all());

        return redirect()->route('admin.station.index');
    }

    public function show(Station $station)
    {
        abort_if(Gate::denies('station_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.station.show', compact('station'));
    }
    
    public function destroy(Station $station)
    {
        abort_if(Gate::denies('station_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $station->delete();

        return back();
    }

    public function massDestroy(MassDestroyStationRequest $request)
    {
        Station::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
