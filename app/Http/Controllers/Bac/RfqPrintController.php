<?php

namespace App\Http\Controllers\Bac;

use App\Models\RequestForQuotation;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RfqPrintController extends Controller
{
    public function print($id)
    {
        $data = RequestForQuotation::with('purchase_request')->find($id);  
        $data_temp = PurchaseRequest::find($data->purchase_request_id);                  
        $purchaseRequestItems = DB::table('purchase_request_items')->where('purchase_request_id', $data->purchase_request_id)->orderBy('id','asc')->get();
        $bac_chair = DB::table('signatories')->where('designation', '=' , "BAC Chairperson")->first();

        return view('bac.print.request_for_quotation', compact('data', 'purchaseRequestItems', 'bac_chair'));
        
    }
}
