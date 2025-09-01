<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\StockCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class StockController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('stock_card_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('supply.stock.index');
    }

    public function getStocks(Request $request)
    {                     
        // Fetch data
        $data = StockCard::orderBy('id', 'asc')->get();

        // Use DataTables with the query
        return datatables($data)->make(true);   

    }

    public function show($id)
    {
        abort_if(Gate::denies('stock_card_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $stockCard = StockCard::with([
            'iar:id,iar_no,date,supplier_id', 
            'iar.supplier:id,name', 
            'asset:id,asset_no,date,supplier_id', 
            'asset.supplier:id,name',  
            'donation:id,donation_no,date,supplier_id',
            'donation.supplier:id,name',  
        ])->findOrFail($id);
   
        return view('supply.stock.show', compact('stockCard'));
    }  
}
