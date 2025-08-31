<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\IcsHv;
use App\Models\IcsItemHv;
use App\Models\Ris;
use App\Models\RisItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RspiHvController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rspi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        return view('supply.rspi_hv.index');
    }

    public function getRspiHv(Request $request)
    {            
        $start_date = $request->get('from');
        $end_date = $request->get('to');
        // Fetch data
        if((!empty($start_date)) && (!empty($end_date))) {
            $data = IcsHv::with(['ics_item_hv'])
                    ->where('date', '>=' , $start_date)->where('date', '<=' , $end_date)
                    ->orderBy('id', 'asc')->get();
        }else{
            $data = IcsHv::with(['ics_item_hv'])->orderBy('id', 'asc')->get();
        }

         return datatables($data)
            ->editColumn('res_code', function ($row) {
                return '01';
            })
            ->editColumn('inventory_item_no', function ($row) {
                return $row->ics_item_hv->inventory_item_no;
            })
            ->editColumn('description', function ($row) {
                return '<span style="white-space:normal">' . e($row->ics_item_hv->description) . '</span>';
            })
            ->editColumn('unit', function($row){
                return $row->ics_item_hv->unit;
            })
            ->editColumn('quantity', function($row){
                return $row->ics_item_hv->quantity;
            })
            ->editColumn('unit_cost', function($row) {
                // Remove commas from the total_cost value
                $unitCost = str_replace(',', '', $row->ics_item_hv->unit_cost);
                // Check if the resulting value is numeric
                if (is_numeric($unitCost)) {
                    // Convert to float and format with commas and two decimal places
                    return number_format((float)$unitCost, 2, '.', ',');
                } else {
                    // Handle cases where total_cost is not a valid number
                    return 'N/A';
                }
            })
            ->editColumn('total_cost', function($row) {
                // Remove commas from the total_cost value
                $totalCost = str_replace(',', '', $row->ics_item_hv->total_cost);
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
