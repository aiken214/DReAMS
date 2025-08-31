<?php

namespace App\Http\Controllers\Supply;

use App\Models\Rsmi;
use App\Models\RisItem;
use App\Models\StockCard;
use App\Models\Employee;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RsmiPrintController extends Controller
{
    public function print($id)
    {
      
        $admin_officer = Signatory::where('designation', "Administrative Officer")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $data= Rsmi::where('id', $id)->first();

        $table_data1 = RisItem::with([
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
     
        $table_data2 = StockCard::select([
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

        return view('supply.print.rsmi', compact('data', 'table_data1', 'table_data2', 'admin_officer', 'supply_officer'));
    }
}
