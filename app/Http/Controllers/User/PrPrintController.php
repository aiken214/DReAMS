<?php

namespace App\Http\Controllers\User;

use App\Models\PurchaseRequestItem;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PrPrintController extends Controller
{
    public function print($id)
    {
        
        $data = PurchaseRequest::find($id);        
        $items = DB::table('purchase_request_items')->where('purchase_request_id', $id)->where('deleted_at', '=', null)->orderBy('description','asc')->paginate(100);
        $end_user = DB::table('purchase_requests')->where('id', $id)->first();
        $total_cost =  DB::table('purchase_request_items')->where('purchase_request_id', $id)->sum('total_cost');        
        $budget_officer = DB::table('signatories')->where('designation', '=' , "Budget Officer")->first();
        $hope = DB::table('signatories')->where('designation', '=' , "Head of Procuring Entity")->first();

        return view('user.print.purchase_request', compact('data', 'items', 'end_user', 'budget_officer', 'hope', 'total_cost'));

    }  
}
