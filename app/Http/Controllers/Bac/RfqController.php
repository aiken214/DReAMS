<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyRfqRequest;
use App\Http\Requests\StoreRfqRequest;
use App\Http\Requests\UpdateRfqRequest;
use App\Models\RequestForQuotation;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RfqController extends Controller
{
    use CsvImportTrait; 

    public function index()
    {
        abort_if(Gate::denies('request_for_quotation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('bac.request_for_quotation.index');
    }

    public function getRequestForQuotations(Request $request)
    {            
        // Fetch data
        $data = RequestForQuotation::with('purchase_request')->orderByDesc('id');

        // Use DataTables with the query
        return datatables($data)
            ->editColumn('reference', function ($row) {
                return $row->purchase_request->pr_no;
            })
            ->editColumn('station', function ($row) {
                return '<span style="white-space:normal">' . e($row->purchase_request->office) . '</span>';
            })
            ->editColumn('purpose', function ($row) {
                return '<span style="white-space:normal">' . e($row->purchase_request->purpose) . '</span>';
            })
            ->editColumn('requester', function ($row) {
                return $row->purchase_request->requested_by;
            })
            ->rawColumns(['reference', 'station', 'purpose', 'requester']) // Specify columns with raw HTML, if applicable
            ->make(true); 

    }  
    
    public function create()
    {
        abort_if(Gate::denies('request_for_quotation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseRequests = PurchaseRequest::whereNotNull('added')->whereNull('quoted')->get();

        return view('bac.request_for_quotation.create', compact('purchaseRequests'));
    }

    public function store(StoreRfqRequest $request)
    {
        $data = $request->all();
        $data['rfq_no'] =  $this->generateRfqNo();

        $date = Carbon::now();
        $purchaseRequest = PurchaseRequest::where('id', $request->purchase_request_id)->first();

        if ($purchaseRequest) {
            $purchaseRequest->quoted = $date;
            $purchaseRequest->save();
        } else {
            // Handle the case where no record is found
            return response()->json(['message' => 'Purchase request not found'], 404);
        }

        $requestForQuotation = RequestForQuotation::create($data);

        return redirect()->route('bac.request_for_quotation.index');
    }

    private function generateRfqNo()
    {
        $last_rfq = RequestForQuotation::where('rfq_no', 'like', 'RFQ%')->orderByDesc('rfq_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'RFQ';

        if (!$last_rfq || !$last_rfq->rfq_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_rfq->rfq_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }

    public function edit(RequestForQuotation $requestForQuotation)
    {
        abort_if(Gate::denies('request_for_quotation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $requestForQuotation->load(['purchase_request']);
        
        return view('bac.request_for_quotation.edit', compact('requestForQuotation'));
    }

    public function update(UpdateRfqRequest $request, RequestForQuotation $requestForQuotation)
    {
        $requestForQuotation->update($request->all());

        return redirect()->route('bac.request_for_quotation.index');
    }

    public function show(RequestForQuotation $requestForQuotation)
    {
        abort_if(Gate::denies('request_for_quotation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $requestForQuotation->load(['purchase_request']);

        return view('bac.request_for_quotation.show', compact('requestForQuotation'));
    }

    public function destroy(RequestForQuotation $requestForQuotation)
    {
        abort_if(Gate::denies('request_for_quotation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchaseRequest = PurchaseRequest::where('id', $requestForQuotation->purchase_request_id)->first();
        $purchaseRequest->quoted = null;
        $purchaseRequest->save();

        $requestForQuotation->delete();

        return back();
    }

    public function massDestroy(MassDestroyRfqRequest $request)
    {
        RequestForQuotation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
