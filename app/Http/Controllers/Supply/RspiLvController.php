<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\IcsLv;
use App\Models\IcsItemLv;
use App\Models\Ris;
use App\Models\RisItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RspiLvController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rspi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
      
        return view('supply.rspi_lv.index');
    }

    public function getRspiLv(Request $request)
    {            
        $start_date = $request->get('from');
        $end_date = $request->get('to');
        // Fetch data
        if((!empty($start_date)) && (!empty($end_date))) {
            $data = IcsItemLv::whereHas('ics_lv', function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('date', [$start_date, $end_date]);
                })
                ->with('ics_lv')
                ->orderBy('id', 'asc')
                ->get();
        }else{
            $data = IcsItemLv::with(['ics_lv'])->orderBy('id', 'asc')->get();
            
        }

         return datatables($data)
            ->editColumn('ics_lv_no', function ($row) {
                return $row->ics_lv->ics_lv_no;
            })
            ->editColumn('date', function ($row) {
                return $row->ics_lv->date;
            })
            ->editColumn('res_code', function ($row) {
                return '01';
            })
            ->editColumn('inventory_item_no', function ($row) {
                return $row->inventory_item_no;
            })
            ->editColumn('description', function ($row) {
                return '<span style="white-space:normal">' . e($row->description) . '</span>';
            })
            ->editColumn('unit', function($row){
                return $row->unit;
            })
            ->editColumn('quantity', function($row){
                return $row->quantity;
            })
            ->editColumn('unit_cost', function($row){
                return $row->unit_cost;
            })
            ->editColumn('total_cost', function($row) {
                // Remove commas from the total_cost value
                $totalCost = str_replace(',', '', $row->total_cost);
                // Check if the resulting value is numeric
                if (is_numeric($totalCost)) {
                    // Convert to float and format with commas and two decimal places
                    return number_format((float)$totalCost, 2, '.', ',');
                } else {
                    // Handle cases where total_cost is not a valid number
                    return 'N/A';
                }
            })
            ->rawColumns(['description'])
            ->make(true);
    }

}
