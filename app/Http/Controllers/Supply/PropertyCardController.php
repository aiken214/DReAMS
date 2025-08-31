<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\PropertyCard;
use App\Models\RisItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class PropertyCardController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('property_card_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;

        $data = PropertyCard::with([
            'iar:id,iar_no,date,supplier_id,purchase_order_id', 
            'iar.supplier:id,name', 
            'iar.purchase_order:id,po_no,purchase_request_id', 
            'iar.purchase_order.purchase_request:id,office,requested_by',
            'asset:id,asset_no,date,office,supplier_id', 
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
            $office = $data->asset?->requester. "/" .$data->asset?->office;
        }else{
            $office = "No records found";
        }

        $amount = $data->receipt_quantity * $data->amount;

        return view('supply.property_card.index', compact('id', 'data', 'item', 'description', 'office', 'amount'));
    }

    public function getPropertyCards(Request $request)
    {                     
        // Fetch data
        $id = $request->property_card_id; 
        // dd($id);
        $risItems = RisItem::with(['ris', 'properties'])->where('property_card_id', $id)->get();
        // dd($risItems);
        return datatables($risItems)
            ->editColumn('date', function($data){
                return $data->ris->date;
            })
            ->editColumn('reference', function($data){
                return $data->ris->ris_no;
            })
            ->editColumn('receipt_quantity', function($data){
                return $data->receipt_quantity;
            })
            ->editColumn('issued_quantity', function($data){
                return $data->issued_quantity;
            }) 
            ->editColumn('office', function($data){
                return $data->ris->office. "/" .$data->ris->recipient;
            }) 
            ->editColumn('balance_quantity', function($data){
                $data->balance_quantity = $data->balance_quantity - $data->issued_quantity;
                return $data->balance_quantity;
            }) 
            ->editColumn('amount', function($data){
                return $data->properties->amount;
            })
            ->editColumn('remarks', function($data){
                return $data->properties->remarks;
            })
            ->make(true);   

    }

}
