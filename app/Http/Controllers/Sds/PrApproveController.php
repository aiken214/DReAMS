<?php

namespace App\Http\Controllers\Sds;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class PrApproveController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('purchase_request_approve_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('sds.purchase_request_approve.index');
    }

    public function getPurchaseRequestApprove(Request $request)
    {            
        $data = PurchaseRequest::whereNotNull('finalized')->whereNotNull('verified')->whereNull('approved')->get();
        
        return datatables($data)->make(true);   

    }

    public function show($id)
    {
        abort_if(Gate::denies('purchase_request_approve_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseRequests = PurchaseRequest::findOrFail($id);

        return view('sds.purchase_request_approve.show', compact('purchaseRequests'));
    }

    public function approve(Request $request)
    {
        abort_if(Gate::denies('purchase_request_approve_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = Carbon::now();
        $purchaseRequests = PurchaseRequest::findOrfail($request->id); 
        $remarks = $request->edit_remarks;
        $remarks_from = '- SDS Office';
        $message = $remarks.' '.$remarks_from;         

        if($request->edit_checked == 0){
            $purchaseRequests->finalized = null;
            $purchaseRequests->checked = null;
            $purchaseRequests->verified = null;
            $purchaseRequests->approved = null; 
            $purchaseRequests->added = null; 
            $purchaseRequests->remarks = $message;           
        }else{
            $purchaseRequests->remarks = 'Approved by SDS Office';
            $purchaseRequests->approved = $date;
        }
        
		$purchaseRequests->update();
		return response()->json([
			'status' => 1,
        ]);
    }

}
