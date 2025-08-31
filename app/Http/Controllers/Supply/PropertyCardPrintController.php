<?php

namespace App\Http\Controllers\Supply;

use App\Models\PropertyCard;
use App\Models\RisItem;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PropertyCardPrintController extends Controller
{
    public function print($id)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        // Fetch data
        $data = PropertyCard::with([
            'iar:id,iar_no,date,supplier_id,purchase_order_id', 
            'iar.supplier:id,name', 
            'iar.purchase_order:id,po_no,purchase_request_id', 
            'iar.purchase_order.purchase_request:id,office,requested_by',
            'asset:id,asset_no,date,office,requester,supplier_id', 
            'asset.supplier:id,name',  
            'donation:id,donation_no,date,donor,supplier_id',
            'donation.supplier:id,name',
        ])->findOrFail($id);

        $parts = explode(',', $data->description, 2);
        if(!empty($parts[1])){
            $item = $parts[0];
            $description = $parts[1];
        }else{
            $item = null;
            $description = $parts[0];
        }

        if(!empty($data->donation)){
            $office = $data->donation?->donor. "/" .$data->donation?->supplier->name;
        }elseif(!empty($data->iar)){
            $office = $data->iar->purchase_order?->purchase_request->office. "/" .$data->iar->purchase_order?->purchase_request->requested_by;
        }elseif(!empty($data->asset)){
            $office = $data->asset?->office. "/" .$data->asset?->requester;
        }else{
            $office = "No records found";
        }
        $amount = $data->receipt_quantity * $data->amount;

        $table_data = RisItem::with(['ris', 'properties'])->where('property_card_id', $id)->get();

        return view('supply.print.property_card', compact('id', 'data', 'table_data', 'item', 'description', 'office', 'amount'));
    }

}
