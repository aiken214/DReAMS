<?php

namespace App\Http\Controllers\Supply;

use App\Models\Iar;
use App\Models\IarItem;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class IarPrintController extends Controller
{
    public function print($id)
    {
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $inscom_chair = Signatory::where('designation', "Inspectorate Committee")->where('role', "Head")->first();

        $data = Iar::with([
            'purchase_request:id,date,pr_no,office,res_code,fund_cluster',
            'purchase_order:id,po_no,date,purchase_request_id',
            'purchase_order.purchase_request:id,office,res_code,fund_cluster', 
            'supplier:id,name'])->where('id', $id)->first(); 
        $table_data = IarItem::select('id', 'stock_no', 'description', 'unit', 'type', 'quantity')->where('iar_id', $data->id)->orderBy('description', 'asc')->get();
        $inscom_member = Signatory::where('type_goods', $table_data[0]->type)->where('designation', "Inspectorate Committee")->where('role', "Member")->get();

        return view('supply.print.iar', compact('data', 'table_data', 'inscom_member', 'supply_officer', 'inscom_chair'));
    }
}
