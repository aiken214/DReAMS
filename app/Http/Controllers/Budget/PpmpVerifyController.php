<?php

namespace App\Http\Controllers\Budget;

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

class PpmpVerifyController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ppmp_verify_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('budget.ppmp_verify.index');
    }

    public function getPpmpVerify(Request $request)
    {            
        $data = Ppmp::whereNotNull('finalized')->whereNotNull('checked')->whereNull('verified')->get();
        
        return datatables($data)->make(true);   

    }

    public function show($id)
    {
        abort_if(Gate::denies('ppmp_verify_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ppmp = Ppmp::findOrFail($id);

        return view('budget.ppmp_verify.show', compact('ppmp'));
    }

    public function approve(Request $request)
    {
        abort_if(Gate::denies('ppmp_verify_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = Carbon::now();
        $ppmps = Ppmp::findOrfail($request->id); 
        $remarks = $request->edit_remarks;
        $remarks_from = '- Budget Office';
        $message = $remarks.' '.$remarks_from;         

        if($request->edit_checked == 0){
            $ppmps->finalized = null;
            $ppmps->checked = null;
            $ppmps->verified = null;
            $ppmps->approved = null; 
            $ppmps->added = null; 
            $ppmps->remarks = $message;           
        }else{
            $ppmps->remarks = 'Verified by Budget Office';
            $ppmps->verified = $date;
        }
        
		$ppmps->update();
		return response()->json([
			'status' => 1,
        ]);
    }

    public function verifiedPpmp()
    {
        abort_if(Gate::denies('ppmp_verify_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('budget.ppmp_verify.verified_ppmp');
    }

    public function getPpmpVerified(Request $request)
    {            
        // $data = Ppmp::whereNotNull('finalized')->whereNotNull('checked')->whereNotNull('verified')->get();
        
        // Fetch data
        $start_date = $request->get('from');
        $end_date = $request->get('to');

        // Initialize query
        $query = Ppmp::whereNotNull('finalized')->whereNotNull('checked')->whereNotNull('verified');
        
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }

        $data = $query->get();

        return datatables($data)->make(true);   

    }

}
