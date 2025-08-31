<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class PrItemCheckController extends Controller
{
    public function index(Request $request)
    {

        abort_if(Gate::denies('purchase_request_item_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $id = $request->id;
        $data = PurchaseRequest::find($id);
        $total_cost =  DB::table('purchase_request_items')->where('purchase_request_id', $id)->sum('total_cost');  

        return view('supply.purchase_request_item_check.index', compact('id', 'data', 'total_cost'));
    }

    public function getPurchaseRequestItemsCheck(Request $request)
    {
        $id = $request->get('purchase_request_id');
        $data = PurchaseRequestItem::with('purchase_request')->where('purchase_request_id', $id)->get();

        return datatables($data)->make(true);  
    }
}
