<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\Ppmp;
use App\Models\User;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class FinalPpmpController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ppmp_final_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('bac.ppmp_final.index');
    }

    public function getPpmpFinal(Request $request)
    {            
        $data = Ppmp::whereNotNull('finalized')->whereNotNull('approved')->get();
        
        return datatables($data)->make(true);   

    }

    public function show($id)
    {
        abort_if(Gate::denies('ppmp_final_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ppmp = Ppmp::findOrFail($id);

        return view('bac.ppmp_final.show', compact('ppmp'));
    }

    public function approve(Request $request)
    {
        abort_if(Gate::denies('ppmp_final_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = Carbon::now();
        $ppmps = Ppmp::findOrfail($request->id); 
        $remarks = $request->edit_remarks;
        $remarks_from = '- BAC Office';
        $message = $remarks.' '.$remarks_from;         

        if($request->edit_checked == 0){
            $ppmps->finalized = null;
            $ppmps->checked = null;
            $ppmps->verified = null;
            $ppmps->approved = null; 
            $ppmps->added = null; 
            $ppmps->remarks = $message;           
        }else{
            $ppmps->remarks = 'Approved by BAC.';
            $ppmps->added = $date;
        }
        
		$ppmps->update();
		return response()->json([
			'status' => 1,
        ]);
    }
}
