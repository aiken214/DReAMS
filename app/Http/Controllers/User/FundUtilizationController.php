<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\FundAllocation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class FundUtilizationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fund_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user_id = Auth::user()->id;

        return view('user.fund_utilization.index', compact('user_id'));
    }

    public function getFundUtilizations(Request $request)
    {            
        $user_id = $request->user_id;

        if($user_id == 1){            
            $data = FundAllocation::all()->sortByDesc('id');
        }else{
            $data = FundAllocation::where('user_id', $user_id)->get();
        }          
        
        return datatables($data)->make(true);   
    }

    public function show($id)
    {
        abort_if(Gate::denies('fund_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $fundAllocation = FundAllocation::findOrFail($id);

        return view('user.fund_utilization.show', compact('fundAllocation'));
    }
}
