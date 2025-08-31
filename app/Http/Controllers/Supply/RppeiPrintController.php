<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Models\Par;
use App\Models\ParItem;
use App\Models\Signatory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RppeiPrintController extends Controller
{
    public function print($from = null, $to = null)
    {
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $accounting_staff = Signatory::where('designation', "Accounting Staff")->first();
        $current_date = Carbon::now();
            $year = $current_date->year;
            $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
            $code = 'RPPEI';
            $serial_no = $code.'-'.$year.'-'.$month.'-00'.$month;

        $start_date = $from;
        $end_date = $to;              
     
        if((!empty($start_date)) && (!empty($end_date))) {
            $data = Par::with(['par_item'])
                    ->where('date', '>=' , $start_date)->where('date', '<=' , $end_date)
                    ->orderBy('id', 'asc')->get();
        }else{
            $data = Par::with(['par_item'])->orderBy('id', 'asc')->get();
       
;        }

        return view('supply.print.rppei', compact('data', 'serial_no', 'start_date', 'end_date', 'supply_officer', 'accounting_staff'));       

    }

}
