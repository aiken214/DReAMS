<?php

namespace App\Http\Controllers\Supply;

use App\Models\Ris;
use App\Models\RisItem;
use App\Models\Employee;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RisPrintController extends Controller
{
    public function print($id)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $alt_supply_officer = Signatory::where('designation', "Alternate Supply Officer")->first();
        $data = Ris::with([
            'iar:id,iar_no',
            'donation:id,donation_no,requester,designation,office,purpose',
            'asset:id,asset_no,requester,designation,office,purpose',
            'purchase_request' => function ($query) {
                $query->addSelect([
                    'purchase_requests.id as purchase_request_id', // Alias to prevent conflict
                    'purchase_requests.requested_by', 
                    'purchase_requests.designation', 
                    'purchase_requests.office', 
                    'purchase_requests.res_code', 
                    'purchase_requests.fund_cluster', 
                    'purchase_requests.purpose'
                ]);
            }
        ])->where('id', $id)->first();
      
        $table_data = RisItem::select('id', 'stock_no', 'unit', 'description', 'issued_quantity', 'issued_quantity', 'remarks')->where('ris_id', $id)->get();
     
        return view('supply.print.ris', compact('data', 'table_data', 'hope', 'supply_officer', 'alt_supply_officer'));
    }
}
