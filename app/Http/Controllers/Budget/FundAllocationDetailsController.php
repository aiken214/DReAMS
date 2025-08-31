<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\FundAllocation;
use App\Models\User;
use App\Models\Ppmp;
use App\Models\PurchaseRequest;
use App\Models\PurchaseOrder;
use App\Models\FundObligation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class FundAllocationDetailsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('fund_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fund_id = $request->id;
        $user_id = Auth::user()->id;

        return view('budget.fund_allocation_details.index', compact('user_id', 'fund_id'));
    }

    public function getFundObligations(Request $request)
    {            
        $user_id = $request->user_id;
        $fund_id = $request->fund_id;
        // Get the user and their roles
        $user = User::with('roles')->find($user_id);

        // Get station_id
        $station_id = $user->station_id;

        // Get user roles (array of role names)
        $roles = $user->roles->pluck('title')->toArray(); 
       
        if (array_intersect(['Admin', 'Budget'], $roles)) {           
            // $data = FundObligation::where('fund_id', $fund_id)->orderByDesc('id')->get();

            $data = FundObligation::where('fund_id', $fund_id)
                ->with([
                    'purchase_order' => function ($query) {
                        $query->select('id', 'po_no', 'supplier_id')->with('supplier:id,name');
                    }
                ])->get();
        } else {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'You do not have permission to access this resource.',
            ], 404);
        }
       
        return datatables($data)->make(true);   

    }

    public function getFundPpmps(Request $request)
    {            
        $user_id = $request->user_id;
        $fund_id = $request->fund_id;
        // Get the user and their roles
        $user = User::with('roles')->find($user_id);

        // Get station_id
        $station_id = $user->station_id;

        // Get user roles (array of role names)
        $roles = $user->roles->pluck('title')->toArray(); 
       
        if (array_intersect(['Admin', 'Budget'], $roles)) {           
            $data = Ppmp::where('fund_id', $fund_id)->orderByDesc('id')->get();
        } else {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'You do not have permission to access this resource.',
            ], 404);
        }
       
        return datatables($data)->make(true);   

    }

    public function getFundPurchaseRequests(Request $request)
    {            
        $user_id = $request->user_id;
        $fund_id = $request->fund_id;
        // Get the user and their roles
        $user = User::with('roles')->find($user_id);

        // Get station_id
        $station_id = $user->station_id;

        // Get user roles (array of role names)
        $roles = $user->roles->pluck('title')->toArray(); 
       
        if (array_intersect(['Admin', 'Budget'], $roles)) {           
            $data = PurchaseRequest::withSum('purchase_request_item', 'total_cost')
                ->where('fund_id', $fund_id)
                ->get();
        } else {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'You do not have permission to access this resource.',
            ], 404);
        }
  
        return datatables($data)->make(true);   

    }

    public function getFundPurchaseOrders(Request $request)
    {            
        $user_id = $request->user_id;
        $fund_id = $request->fund_id;
        // Get the user and their roles
        $user = User::with('roles')->find($user_id);

        // Get station_id
        $station_id = $user->station_id;

        // Get user roles (array of role names)
        $roles = $user->roles->pluck('title')->toArray(); 
       
        if (array_intersect(['Admin', 'Budget'], $roles)) {           
            $purchaseRequests = PurchaseRequest::where('fund_id', $fund_id)->get();
            $data = PurchaseOrder::with([
                    'purchase_order_item', 
                    'purchase_request', 
                    'supplier'
                ])
                ->withSum('purchase_order_item', 'amount') // Get the sum of `amount` in `purchase_order_item`
                ->whereIn('purchase_request_id', $purchaseRequests->pluck('id')->toArray())
                ->get();
        } else {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'You do not have permission to access this resource.',
            ], 404);
        }

        return datatables($data)
            ->editColumn('supplier', function ($row) {
                return $row->supplier->name;
            })
            ->editColumn('pr_no', function ($row) {
                return $row->purchase_request->pr_no;
            })
            ->editColumn('purpose', function ($row) {
                return '<span style="white-space:normal">' . e($row->purchase_request->purpose) . '</span>';
            })
            ->editColumn('fund_source', function ($row) {
                return '<span style="white-space:normal">' . e($row->purchase_request->fund_source) . '</span>';
            })
            ->rawColumns(['supplier', 'pr_no', 'purpose', 'fund_source']) // Specify columns with raw HTML, if applicable
            ->make(true); 

    }
}
