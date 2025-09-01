<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAssetRequest;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use App\Models\DavnorsysEmployee;
use App\Models\Position;
use App\Models\Station;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class AssetController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('asset_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        return view('supply.asset.index');
    }

    public function getAssets(Request $request)
    {            
                
        $data = Asset::with(['supplier'])->get();

        return datatables($data)->make(true);   
    }

    public function create()
    {
        abort_if(Gate::denies('asset_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = DavnorsysEmployee::orderBy('fullname', 'asc')->get();
        $designations = Position::orderBy('position', 'asc')->get();
        $stations = Station::orderBy('station_name', 'asc')->get();
        $suppliers = Supplier::all()->sortBy('name');

        return view('supply.asset.create', compact('employees', 'designations', 'stations', 'suppliers'));
    }

    public function store(StoreAssetRequest $request)
    {
        abort_if(Gate::denies('asset_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
        $data['asset_no'] =  $this->generateAssetNo();
       
        $asset = Asset::create($data);

        return redirect()->route('supply.asset.index');
    }

    private function generateAssetNo()
    {
        $last_asset = Asset::where('asset_no', 'like', 'AN%')->orderByDesc('asset_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'AN';

        if (!$last_asset || !$last_asset->asset_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_asset->asset_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }

    
    public function edit(Asset $asset)
    {
        abort_if(Gate::denies('asset_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $asset->load(['supplier:id,name']);
        $employees = DavnorsysEmployee::orderBy('fullname', 'asc')->get();
        $designations = Position::orderBy('position', 'asc')->get();
        $stations = Station::orderBy('station_name', 'asc')->get();
        $suppliers = Supplier::all()->sortBy('name');

        return view('supply.asset.edit', compact('asset', 'employees', 'designations', 'stations', 'suppliers'));
    }

    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        abort_if(Gate::denies('asset_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $asset->update($request->all());

        return redirect()->route('supply.asset.index');
    }

    public function show(Asset $asset)
    {
        abort_if(Gate::denies('asset_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $asset->load(['supplier:id,name']);

        return view('supply.asset.show', compact('asset'));
    }

    public function destroy(Asset $asset)
    {
        abort_if(Gate::denies('asset_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $asset->delete();

        return back();
    }

    public function massDestroy(MassDestroyAssetRequest $request)
    {
        abort_if(Gate::denies('asset_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        Asset::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
