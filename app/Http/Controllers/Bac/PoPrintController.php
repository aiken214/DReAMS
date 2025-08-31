<?php

namespace App\Http\Controllers\Bac;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PoPrintController extends Controller
{
    //Print Preview Purchase Request
    public function print($id)
    {
        $data = PurchaseOrder::with(['purchase_request:id,pr_no,date,purpose,fund_source', 'supplier:id,name,address,tin'])->find($id);
        $items = DB::table('purchase_order_items')->where('purchase_order_id', $id)->where('deleted_at', '=', null)->orderBy('description','asc')->paginate(100);
        $totalCost =  DB::table('purchase_order_items')->where('purchase_order_id', $id)->sum('amount');  
        $hope = DB::table('signatories')->where('designation', "=" , "Head of Procuring Entity")->first();
        $accountant = DB::table('signatories')->where('designation', "=" , "Accountant")->first();
        
        return view('bac.print.purchase_order', compact('data', 'items', 'hope', 'accountant', 'totalCost'));
        
    }

    public function print_check($id)
    {
        $data = PurchaseOrder::with(['purchase_request:id,pr_no,date,purpose,fund_source', 'supplier:id,name,address,tin'])->find($id);
        $items = DB::table('purchase_order_items')->where('purchase_order_id', $id)->where('deleted_at', '=', null)->orderBy('description','asc')->paginate(100);
        $totalCost =  DB::table('purchase_order_items')->where('purchase_order_id', $id)->sum('amount');  
        $hope = DB::table('signatories')->where('designation', "=" , "Head of Procuring Entity")->first();
        $accountant = DB::table('signatories')->where('designation', "=" , "Accountant")->first();
        
        return view('supply.print.purchase_order', compact('data', 'items', 'hope', 'accountant', 'totalCost'));
        
    }
}
