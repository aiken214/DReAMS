<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPpmpRequest;
use App\Http\Requests\StorePpmpRequest;
use App\Http\Requests\UpdatePpmpRequest;
use App\Models\Ppmp;
use App\Models\User;
use App\Models\Station;
use App\Models\FundAllocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class PpmpController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ppmp_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $user_id = Auth::user()->id;

        return view('user.ppmp.index', compact('user_id'));
    }

    public function getPpmps(Request $request)
    {            
        $user_id = $request->user_id;
        $station_id = User::where('id', $user_id)->first()->station_id;

        if($user_id == 1){            
            $data = Ppmp::all()->sortByDesc('id');
        }else{
            $data = Ppmp::where('station_id', $station_id)->get();
        }  
        
        return datatables($data)->make(true);   

    }

    public function create()
    {
        abort_if(Gate::denies('ppmp_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user_id = Auth::user()->id;
        $fundSources = FundAllocation::where('user_id', $user_id)->orderBy('legal_basis', 'asc')->get();

        return view('user.ppmp.create', compact('fundSources'));
    }

    public function store(StorePpmpRequest $request)
    {
        $data = $request->all();
        $data['station_id'] = Auth::user()->station_id;
        $data['prepared_by'] = Auth::user()->name;
        $data['station'] = Auth::user()->station->station_name;
        $fund_source = FundAllocation::find($data['fund_id']);
       
        $data['fund_source'] = $fund_source->legal_basis;
        
        $ppmp = Ppmp::create($data);

        return redirect()->route('user.ppmp.index');
    }

    public function edit(Ppmp $ppmp)
    {
        abort_if(Gate::denies('ppmp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('user.ppmp.edit', compact('ppmp'));
    }

    public function update(UpdatePpmpRequest $request, Ppmp $ppmp)
    {
        $ppmp->update($request->all());

        return redirect()->route('user.ppmp.index');
    }

    public function show(Ppmp $ppmp)
    {
        abort_if(Gate::denies('ppmp_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('user.ppmp.show', compact('ppmp'));
    }
    
    public function destroy(Ppmp $ppmp)
    {
        abort_if(Gate::denies('ppmp_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ppmp->delete();

        return back();
    }

    public function finalize(Request $request)
    {
        abort_if(Gate::denies('ppmp_finalize'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = Carbon::now();
        $var1 = 'For Approval';
        $id = $request->id;
        $ppmps = Ppmp::findOrfail($id);
        $ppmps->finalized = $date;
        $ppmps->remarks = $var1;
        $ppmps->update(); 
    }

    public function revert(Request $request)
    {
        abort_if(Gate::denies('ppmp_revert'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $var1 = 'Request for PPMP Reversal - End User.';
        $id = $request->id;
        $ppmps = Ppmp::findOrfail($id);
        $ppmps->remarks = $var1;
        $ppmps->update();  
    }
}
