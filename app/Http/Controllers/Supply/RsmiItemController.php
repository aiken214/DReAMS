<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\Rsmi;
use App\Models\Ris;
use App\Models\RisItem;
use App\Models\Iar;
use App\Models\IarItem;
use App\Models\Donation;
use App\Models\Asset;
use App\Models\StockCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RsmiItemController extends Controller
{
    public function index(Request $request)
    {        
        $id = $request->id;

        return view('supply.rsmi_item.index', compact('id'));
    }

    public function getRsmiItems(Request $request )
    {   
        $id = $request->rsmi_id; 
       
        $data = RisItem::with([
            'ris:id,ris_no', 
            'stocks:id,unit_price',
        ])
        ->whereHas('stocks', function ($query) use ($id) {
            $query->where('rsmi_id', $id);
        })
        ->orderBy('ris_id', 'asc') // Ensure ris_id is ordered
        ->get()
        ->map(function ($row) {
            return [
                'id' => $row->id,
                'ris_no' => $row->ris->ris_no, // Move ris_no here to make it sortable
                'res_code' => "01",
                'stock_no' => $row->stock_no,
                'description' => $row->description,
                'unit' => $row->unit,
                'issued_quantity' => $row->issued_quantity,
                'unit_cost' => $row->stocks->unit_price,
                'amount' => number_format($row->issued_quantity * $row->stocks->unit_price, 2, '.', ','),
            ];
        });
    
        return datatables()->collection($data)->make(true);
    }
    
    public function getRecapItems(Request $request)
    {        
        $id = $request->rsmi_id; 
    
        $data1 = StockCard::select([
                'id', // Ensure an ID column is present
                'stock_no', 
                'description', 
                'unit', 
                'unit_price', 
                'receipt_quantity', 
                DB::raw('SUM(receipt_quantity) as total_quantity'), 
                DB::raw('SUM(amount) as total_amount')
            ])
            ->where('rsmi_id', $id)
            ->groupBy('id', 'stock_no', 'description', 'unit', 'unit_price', 'receipt_quantity')
            ->get();
    
        return datatables()->of($data1)
            ->editColumn('stock_no', function($row){
                return $row->stock_no;
            })
            ->editColumn('receipt_quantity', function($row){
                return $row->total_quantity;
            })
            ->editColumn('description', function($row){
                return '<span style="white-space:normal">' . e($row->description) . '</span>';
            })
            ->editColumn('unit', function($row){                
                return $row->unit;                
            })
            ->editColumn('unit_price', function($row){                
                return $row->unit_price;                
            })
            ->editColumn('amount', function($row){
                return number_format($row->total_amount, 2, '.', ',');
            }) 
            ->editColumn('uacs_code', function($row){
                return null;
            })
            ->rawColumns(['description']) 
            ->make(true);  
    }
}
