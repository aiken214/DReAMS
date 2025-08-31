<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\RequestForQuotation;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RfqItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('request_for_quotation_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->id;
        $purchase_request_id = RequestForQuotation::find($id)->purchase_request_id;
        
        return view('bac.request_for_quotation_item.index', compact('id', 'purchase_request_id'));
    }

    public function getRequestForQuotationItems(Request $request)
    {            
        $purchase_request_id = $request->purchase_request_id;
        $data = PurchaseRequestItem::with(['purchase_request'])->where('purchase_request_id', $purchase_request_id)->get();
       
        return datatables($data)->make(true);   

    }

}
