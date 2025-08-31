<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPrRequest;
use App\Http\Requests\StorePrRequest;
use App\Http\Requests\UpdatePrRequest;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\PpmpItem;
use App\Models\User;
use App\Models\Station;
use App\Models\Ppmp;
use App\Models\FundAllocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class PrController extends Controller
{
    use CsvImportTrait; 

    public function index()
    {
        abort_if(Gate::denies('purchase_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $user_id = Auth::user()->id;

        return view('user.purchase_request.index', compact('user_id'));
    }

    public function getPurchaseRequests(Request $request)
    {            
        $user_id = $request->user_id;
        $station_id = User::where('id', $user_id)->first()->station_id;

        if($user_id == 1){            
            $data = PurchaseRequest::all()->sortByDesc('id');
        }else{
            $data = PurchaseRequest::where('station_id', $station_id)->get();
        }  
        
        return datatables($data)->make(true);   

    }

    public function create()
    {
        abort_if(Gate::denies('purchase_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user_id = Auth::user()->id;

        $ppmpFunds = FundAllocation::with('ppmp') // Ensure the relationship is eager loaded
            ->where('user_id', $user_id)
            ->whereHas('ppmp', function ($query) {
                $query->whereNull('deleted_at'); // Filter only active PPMPs
            })
            // ->orderBy('ppmps.fund_source', 'asc') // Order by fund source
            ->get();

        $pettyCashFunds = FundAllocation::whereRaw("LOWER(legal_basis) LIKE LOWER(?)", ['%petty%'])
            ->where('unobligated', '>', 0)
            ->whereNull('deleted_at')
            ->get();

       // Combine the two results
        $fundSources = $ppmpFunds->merge($pettyCashFunds);

        return view('user.purchase_request.create', compact('fundSources'));
    }

    public function store(StorePrRequest $request)
    {
        $data = $request->all();
        $station = Auth::user()->station_id;
        $data['station_id'] = Auth::user()->station_id;
        $data['requested_by'] = Auth::user()->name;
        $data['office'] = Auth::user()->station->station_name;
        $data['designation'] = Auth::user()->position->position; 

        $fund_source = Ppmp::where('fund_id', ($data['fund_id']))->first();
        if (is_null($fund_source)) {
            $fund_source = FundAllocation::where('id', ($data['fund_id']))->first();
            $data['fund_source'] = $fund_source->legal_basis;
            $data['ppmp_id'] = null;
        } else {
            $data['fund_source'] = $fund_source->fund_source;
        }

        $purchaseRequest = PurchaseRequest::create($data);

        return redirect()->route('user.purchase_request.index');
    }

    public function edit(PurchaseRequest $purchaseRequest)
    {
        abort_if(Gate::denies('purchase_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('user.purchase_request.edit', compact('purchaseRequest'));
    }

    public function update(UpdatePrRequest $request, PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->update($request->all());

        return redirect()->route('user.purchase_request.index');
    }

    public function show(PurchaseRequest $purchaseRequest)
    {
        abort_if(Gate::denies('purchase_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('user.purchase_request.show', compact('purchaseRequest'));
    }
    
    public function destroy(PurchaseRequest $purchaseRequest)
    {
        abort_if(Gate::denies('purchase_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseRequestItems = PurchaseRequestItem::where('purchase_request_id', $purchaseRequest->id)->get();

        foreach ($purchaseRequestItems as $purchaseRequestItem) {
            $ppmpItem = PpmpItem::find($purchaseRequestItem->ppmp_item_id);
            $ppmpItem->balance = $ppmpItem->balance + $purchaseRequestItem->quantity;
            $ppmpItem->requested = $ppmpItem->requested - $purchaseRequestItem->quantity;
            
            $ppmpItem->save();
        }
        $purchaseRequest->delete();

        return back();
    }

    public function massDestroy(MassDestroyPrRequest $request)
    {
        // Retrieve the PurchaseRequests to be deleted
        $purchaseRequests = PurchaseRequest::whereIn('id', $request->input('ids'))->get();

        foreach ($purchaseRequests as $purchaseRequest) {
            // Retrieve the related PurchaseRequestItems
            $purchaseRequestItems = PurchaseRequestItem::where('purchase_request_id', $purchaseRequest->id)->get(); // Assuming a relationship exists

            foreach ($purchaseRequestItems as $purchaseRequestItem) {
                // Find the related PpmpItem
                $ppmpItem = PpmpItem::find($purchaseRequestItem->ppmp_item_id);

                if ($ppmpItem) {
                    // Update balance and requested fields
                    $ppmpItem->balance += $purchaseRequestItem->quantity;
                    $ppmpItem->requested -= $purchaseRequestItem->quantity;
                    $ppmpItem->save();
                }
            }

            // The PurchaseRequestItems will be deleted automatically if cascading is set in the DB
            $purchaseRequest->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function finalize(Request $request)
    {
        abort_if(Gate::denies('purchase_request_finalize'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = Carbon::now();
        $var1 = 'For Approval';
        $id = $request->id;
        $purchaseRequest = PurchaseRequest::findOrfail($id);
        $purchaseRequest->finalized = $date;
        $purchaseRequest->remarks = $var1;
        $purchaseRequest->update(); 
    }

    public function revert(Request $request)
    {
        abort_if(Gate::denies('purchase_request_revert'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $var1 = 'Request for PR reversal - End User.';
        $id = $request->id;
        $purchaseRequest = PurchaseRequest::findOrfail($id);
        $purchaseRequest->remarks = $var1;
        $purchaseRequest->update();  
    }
    
}
