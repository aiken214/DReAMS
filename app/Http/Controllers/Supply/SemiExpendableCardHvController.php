<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\SemiExpendableCard;
use App\Models\RisItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class SemiExpendableCardHvController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('semi_expendable_card_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;

        $data = SemiExpendableCard::with([
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

        $quantity = is_numeric($data->receipt_quantity) ? (float) $data->receipt_quantity : 0;
        $unit_price = is_numeric(str_replace(',', '', $data->unit_price)) 
            ? (float) str_replace(',', '', $data->unit_price) 
            : 0;
        $amount = $quantity * $unit_price;

        return view('supply.semi_expendable_card_hv.index', compact('id', 'data', 'item', 'description', 'office', 'amount', 'unit_price'));
    }

    public function getSemiExpendableCardHvs(Request $request)
    {                  
        // Fetch data
        $id = $request->semi_expendable_card_id; 
       
        $risItems = RisItem::with(['ris', 'semi_expendables'])->where('semi_expendable_card_id', $id)->get();
    //  dd($risItems);
        return datatables($risItems)
            ->editColumn('date', function($data){
                return $data->ris->date;
            })
            ->editColumn('reference', function($data){
                return $data->ris->ris_no;
            })
            ->editColumn('receipt_quantity', function($data){
                return $data->issued_quantity;
            })
            ->editColumn('unit_cost', function($data){
                $unitCost = str_replace(',', '', (string) optional($data->semi_expendables)->unit_price);
                return is_numeric($unitCost) ? number_format((float)$unitCost, 2) : '0.00';
            })
            ->editColumn('total_cost', function($data){
                $totalCost = str_replace(',', '', (string) optional($data->semi_expendables)->unit_price) * $data->issued_quantity;
                return is_numeric($totalCost) ? number_format((float)$totalCost, 2) : '0.00';
            })
            ->editColumn('stock_no', function($data){
                return $data->semi_expendables->stock_no;
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
            ->editColumn('amount', function ($data) {
                $amount = str_replace(',', '', (string) optional($data->semi_expendables)->unit_price) * $data->issued_quantity;
                return is_numeric($amount) ? number_format((float)$amount, 2) : '0.00';
            })
            ->editColumn('remarks', function($data){
                return $data->semi_expendables->remarks;
            })
            ->make(true);   

    }

}
