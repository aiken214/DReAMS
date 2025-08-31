<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class FinalPrController extends Controller
{
    use CsvImportTrait; 
    
    public function index()
    {
        abort_if(Gate::denies('purchase_request_final_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('bac.purchase_request_final.index');
    }

    public function getPurchaseRequestFinal(Request $request)
    {            
        $data = PurchaseRequest::whereNotNull('finalized')->whereNotNull('approved')->get();
        
        return datatables($data)->make(true);   

    }

    public function show($id)
    {
        abort_if(Gate::denies('purchase_request_final_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseRequests = PurchaseRequest::findOrFail($id);

        return view('bac.purchase_request_final.show', compact('purchaseRequests'));
    }

    public function approve(Request $request)
    {
        abort_if(Gate::denies('purchase_request_final_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = Carbon::now();
        $purchaseRequests = PurchaseRequest::findOrfail($request->id); 
        $remarks = $request->edit_remarks;
        $remarks_from = '- BAC';
        $message = $remarks.' '.$remarks_from;         

        if($request->edit_checked == 0){
            $purchaseRequests->finalized = null;
            $purchaseRequests->checked = null;
            $purchaseRequests->verified = null;
            $purchaseRequests->approved = null; 
            $purchaseRequests->added = null; 
            $purchaseRequests->remarks = $message;           
        }else{
            $purchaseRequests->remarks = 'Read by BAC.';
            $purchaseRequests->added = $date;
        }
        
		$purchaseRequests->update();
		return response()->json([
			'status' => 1,
        ]);
    }
}
