<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class PrVerifyController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('purchase_request_verify_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('budget.purchase_request_verify.index');
    }

    public function getPurchaseRequestVerify(Request $request)
    {            
        $data = PurchaseRequest::whereNotNull('finalized')->whereNotNull('checked')->whereNull('verified')->get();
        
        return datatables($data)->make(true);   

    }

    public function show($id)
    {
        abort_if(Gate::denies('purchase_request_verify_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseRequests = PurchaseRequest::findOrFail($id);

        return view('budget.purchase_request_verify.show', compact('purchaseRequests'));
    }

    public function approve(Request $request)
    {
        abort_if(Gate::denies('purchase_request_verify_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = Carbon::now();
        $purchaseRequests = PurchaseRequest::findOrfail($request->id); 
        $remarks = $request->edit_remarks;
        $remarks_from = '- Budget Office';
        $message = $remarks.' '.$remarks_from;         

        if($request->edit_checked == 0){
            $purchaseRequests->finalized = null;
            $purchaseRequests->checked = null;
            $purchaseRequests->verified = null;
            $purchaseRequests->approved = null; 
            $purchaseRequests->added = null; 
            $purchaseRequests->remarks = $message;           
        }else{
            $purchaseRequests->remarks = 'Verified by Budget Office';
            $purchaseRequests->verified = $date;
        }
        
		$purchaseRequests->update();
		return response()->json([
			'status' => 1,
        ]);
    }

    public function verifiedPr()
    {
        abort_if(Gate::denies('ppmp_verify_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('budget.purchase_request_verify.verified_purchase_request');
    }

    public function getPrVerified(Request $request)
    {            
        // $data = Ppmp::whereNotNull('finalized')->whereNotNull('checked')->whereNotNull('verified')->get();
        
        // Fetch data
        $start_date = $request->get('from');
        $end_date = $request->get('to');

        // Initialize query
        $query = PurchaseRequest::whereNotNull('finalized')->whereNotNull('checked')->whereNotNull('verified')
                ->withSum('purchase_request_item as total_cost_sum', 'total_cost');
        
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }

        $data = $query->get();

        return datatables($data)->make(true);   

    }
}
