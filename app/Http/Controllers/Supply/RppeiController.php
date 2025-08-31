<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\Par;
use App\Models\ParItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RppeiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rspi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
     
        return view('supply.rppei.index');
    }

    public function getRppei(Request $request)
    {            
        $start_date = $request->get('from');
        $end_date = $request->get('to');
        // Fetch data
        if((!empty($start_date)) && (!empty($end_date))) {
            $data = Par::with(['par_item'])
                    ->where('date', '>=' , $start_date)->where('date', '<=' , $end_date)
                    ->orderBy('id', 'asc')->get();
        }else{
            $data = Par::with(['par_item'])->orderBy('id', 'asc')->get();
        }

         return datatables($data)
            ->editColumn('res_code', function ($row) {
                return '01';
            })
            ->editColumn('property_no', function ($row) {
                return optional($row->par_item->first())->property_no;
            })
            ->editColumn('description', function ($row) {
                return '<span style="white-space:normal">' . e(optional($row->par_item->first())->description) . '</span>';
            })
            ->editColumn('unit', function($row){
                return optional($row->par_item->first())->unit;
            })
            ->editColumn('quantity', function($row){
                return optional($row->par_item->first())->quantity;
            })
            ->editColumn('unit_cost', function($row) {
                // Remove commas from the total_cost value
                $unitCost = str_replace(',', '', optional($row->par_item->first())->amount);
                // Check if the resulting value is numeric
                if (is_numeric($unitCost)) {
                    // Convert to float and format with commas and two decimal places
                    return number_format((float)$unitCost, 2, '.', ',');
                } else {
                    // Handle cases where total_cost is not a valid number
                    return 'N/A';
                }
            })
            ->editColumn('amount', function($row) {
                // Remove commas from the total_cost value
                $totalCost = str_replace(',', '', optional($row->par_item->first())->amount);
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
