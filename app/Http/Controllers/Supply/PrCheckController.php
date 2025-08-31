<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\PurchaseRequest;
use App\Models\User;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class PrCheckController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('purchase_request_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.purchase_request_check.index');
    }

    public function getPurchaseRequestCheck(Request $request)
    {            
        $data = PurchaseRequest::whereNotNull('finalized')->get();
        
        return datatables($data)->make(true);   

    }

    public function show($id)
    {
        abort_if(Gate::denies('purchase_request_check_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseRequests = PurchaseRequest::findOrFail($id);

        return view('supply.purchase_request_check.show', compact('purchaseRequests'));
    }
    
    public function approve(Request $request)
    {
        abort_if(Gate::denies('purchase_request_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = Carbon::now();
        $purchaseRequests = PurchaseRequest::findOrfail($request->id); 
        $remarks = $request->edit_remarks;
        $remarks_from = '- Supply Office';
        $message = $remarks.' '.$remarks_from;         

        if($request->edit_checked == 0){
            $purchaseRequests->finalized = null;
            $purchaseRequests->checked = null;
            $purchaseRequests->checked = null;
            $purchaseRequests->approved = null; 
            $purchaseRequests->added = null; 
            $purchaseRequests->remarks = $message;           
        }else{
            // Generate PR No. if needed
            if (!$request->edit_pr_no) {
                $purchaseRequests->pr_no = $this->generatePrNo();
            } else {
                $purchaseRequests->pr_no = $request->edit_pr_no;
            }

            // Mark as checked
            $purchaseRequests->checked = $date;
        }
        
		$purchaseRequests->update();
		return response()->json([
			'status' => 1,
        ]);
    }

    private function generatePrNo()
    {
        $last_pr = PurchaseRequest::where('pr_no', 'like', 'PR%')->orderByDesc('pr_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'PR';

        if (!$last_pr || !$last_pr->pr_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_pr->pr_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }

    public function revert(Request $request)
    {
        abort_if(Gate::denies('purchase_request_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $var1 = null;
        $var2 = '';
        $id = $request->id;
        $purchaseRequests = PurchaseRequest::findOrfail($id);
        $purchaseRequests->finalized = $var1;
        $purchaseRequests->checked = $var1;
        $purchaseRequests->checked = $var1;
        $purchaseRequests->approved = $var1;
        $purchaseRequests->remarks = $var2;
        $purchaseRequests->update();   
    }

    
    public function checkedPr()
    {
        abort_if(Gate::denies('ppmp_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.purchase_request_check.checked_purchase_request');
    }

    public function getPrChecked(Request $request)
    {            
        // $data = Ppmp::whereNotNull('finalized')->whereNotNull('checked')->whereNotNull('checked')->get();
        
        // Fetch data
        $start_date = $request->get('from');
        $end_date = $request->get('to');

        // Initialize query
        $query = PurchaseRequest::whereNotNull('finalized')->whereNotNull('checked')
                ->withSum('purchase_request_item as total_cost_sum', 'total_cost');
        
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }

        $data = $query->get();

        return datatables($data)->make(true);   

    }
}
