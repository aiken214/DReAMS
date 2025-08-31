<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFundObligationRequest;
use App\Http\Requests\StoreFundObligationRequest;
use App\Http\Requests\UpdateFundObligationRequest;
use App\Models\FundObligation;
use App\Models\FundAllocation;
use App\Models\User;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class FundObligationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fund_obligation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('budget.fund_obligation.index');
    }

    public function getFundObligations(Request $request)
    {                
        $data = FundObligation::with([
                'purchase_order' => function ($query) {
                    $query->select('id', 'po_no', 'supplier_id')->with('supplier:id,name');
                }
            ])->get();

        return datatables($data)->make(true);   

    }

    public function show(FundObligation $fundObligation)
    {
        abort_if(Gate::denies('fund_obligation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $fundObligation->id;        
        $purchaseOrder = PurchaseOrder::with('supplier')->where('fund_obligation_id', $id)->first();
      
        return view('budget.fund_obligation.show', compact('fundObligation', 'purchaseOrder'));
    }

    public function create()
    {
        abort_if(Gate::denies('fund_obligation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseOrders = PurchaseOrder::whereNull('fund_obligation_id')
            ->withSum('purchase_order_item', 'amount') // Get sum of amount
            ->with('purchase_request:id,fund_id') // Load only fund_id from purchase_request
            ->with('supplier:id,name') // Load only fund_id from purchase_request
            ->get(['id', 'po_no', 'purchase_request_id']); // Select only necessary fields

        return view('budget.fund_obligation.create', compact('purchaseOrders'));
    }

    public function store(StoreFundObligationRequest $request)
    {
        $data = $request->all();
        $purchaseOrderId = $request->purchase_order_id;
        $fundAllocationId = $request->fund_id;

        $fundObligation = FundObligation::create($data);       
        $purchaseOrder = PurchaseOrder::find($purchaseOrderId);
            if ($purchaseOrder) {
                $purchaseOrder->fund_obligation_id = $fundObligation->id; // Assign new value
                $purchaseOrder->save(); // Save the changes
            } else {
                return response()->json(['message' => 'Purchase Order not found'], 404);
            }
        
        $fundAllocation = FundAllocation::find($fundAllocationId);
            if ($fundAllocation) {
                $fundAllocation->obligated = $request->amount + $fundAllocation->obligated; // Assign new value
                $fundAllocation->unobligated = $fundAllocation->unobligated - $request->amount; // Assign new value
                $fundAllocation->save(); // Save the changes
            } else {
                return response()->json(['message' => 'Fund Allocation not found'], 404);
            }

        return redirect()->route('budget.fund_obligation.index');
    }

    public function edit(FundObligation $fundObligation)
    {
        abort_if(Gate::denies('fund_allocation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $fundObligation->load(['purchase_order:id,po_no']);
        
        return view('budget.fund_obligation.edit', compact('fundObligation'));
    }

    public function update(UpdateFundObligationRequest $request, FundObligation $fundObligation)
    {      
        $data = $request->all();
        $fundAllocationId = $request->fund_id;

        $fundAllocation = FundAllocation::find($fundAllocationId);
        if ($fundAllocation) {
            $obligatedAmount = $fundAllocation->obligated - $fundObligation->amount;
            $fundAllocation->obligated = $request->amount + $obligatedAmount; // Assign new value
            $fundAllocation->unobligated = $fundAllocation->amount - $fundAllocation->obligated; // Assign new value
            $fundAllocation->save(); // Save the changes
        } else {
            return response()->json(['message' => 'Fund Allocation not found'], 404);
        }

        $fundObligation->update($request->all());

        return redirect()->route('budget.fund_obligation.index');
    }

    public function destroy(FundObligation $fundObligation)
    {
        abort_if(Gate::denies('fund_obligation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseOrder = PurchaseOrder::where('fund_obligation_id', $fundObligation->id)->first();
            if ($purchaseOrder) {
                $purchaseOrder->fund_obligation_id = null; // Assign new value
                $purchaseOrder->save(); // Save the changes
            } else {
                return response()->json(['message' => 'Purchase Order not found'], 404);
            }

        $fundAllocation = FundAllocation::find($fundObligation->fund_id);
            if ($fundAllocation) {
                $obligatedAmount = $fundObligation->amount;
                $fundAllocation->obligated = $fundAllocation->obligated - $obligatedAmount; // Assign new value
                $fundAllocation->unobligated = $fundAllocation->unobligated + $obligatedAmount; // Assign new value
                $fundAllocation->save(); // Save the changes
            } else {
                return response()->json(['message' => 'Fund Allocation not found'], 404);
            }

        $fundObligation->delete();

        return back();
    }

    public function massDestroy(MassDestroyFundObligationRequest $request)
    {
        $fundObligations = FundObligation::find(request('ids'));

        foreach ($fundObligations as $fundObligation) {
            $purchaseOrder = PurchaseOrder::where('fund_obligation_id', $fundObligation->purchase_order_id)->first();
                if ($purchaseOrder) {
                    $purchaseOrder->fund_obligation_id = null; // Assign new value
                    $purchaseOrder->save(); // Save the changes
                } else {
                    return response()->json(['message' => 'Purchase Order not found'], 404);
                }

            $fundAllocation = FundAllocation::find($fundObligation->fund_id);
                if ($fundAllocation) {
                    $obligatedAmount = $fundObligation->amount;
                    $fundAllocation->obligated = $fundAllocation->obligated + $obligatedAmount; // Assign new value
                    $fundAllocation->save(); // Save the changes
                } else {
                    return response()->json(['message' => 'Fund Allocation not found'], 404);
                }

            $fundObligation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
