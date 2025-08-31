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


class NodPrintController extends Controller
{
    public function print($id)
    {
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $auditor = Signatory::where('designation', "Audit Team Leader")->first();
        $data = Iar::with([
            'purchase_order:id,date,po_no,delivery_place,purchase_request_id',
            'purchase_order.purchase_request:id,office,purpose', 
            'supplier:id,name'])
            ->where('id', $id)
            ->orderBy('id', 'asc')->first();
          
        $amount = IarItem::where('iar_id', $id)
            ->where('category', '!=', 'Services')
            ->with('purchase_order_item')
            ->get()
            ->sum(function ($item) {
                return optional($item->purchase_order_item)->amount ?? 0;
            });
        
        return view('supply.print.nod', compact('data', 'amount', 'auditor', 'supply_officer'));
    }
}
