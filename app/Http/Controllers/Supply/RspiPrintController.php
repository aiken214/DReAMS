<?php

namespace App\Http\Controllers\Supply;

use App\Models\IcsHv;
use App\Models\IcsItemLv;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RspiPrintController extends Controller
{
    public function print_hv($from = null, $to = null)
    {
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $accounting_staff = Signatory::where('designation', "Accounting Staff")->first();
        $current_date = Carbon::now();
            $year = $current_date->year;
            $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
            $code = 'RSPI';
            $serial_no = $code.'-'.$year.'-'.$month.'-00'.$month;

        $start_date = $from;
        $end_date = $to;              
     
        if((!empty($start_date)) && (!empty($end_date))) {
            $data = IcsHv::with(['ics_item_hv'])
                    ->where('date', '>=' , $start_date)->where('date', '<=' , $end_date)
                    ->orderBy('id', 'asc')->get();
        }else{
            $data = IcsHv::with(['ics_item_hv'])->orderBy('id', 'asc')->get();
        
        }

        return view('supply.print.rspi_hv', compact('data', 'serial_no', 'start_date', 'end_date', 'supply_officer', 'accounting_staff'));       

    }

    public function print_lv($from = null, $to = null)
    {
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $accounting_staff = Signatory::where('designation', "Accounting Staff")->first();
        $current_date = Carbon::now();
            $year = $current_date->year;
            $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
            $code = 'RSPI';
            $serial_no = $code.'-'.$year.'-'.$month.'-00'.$month;

        $start_date = $from;
        $end_date = $to;              
     
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

        return view('supply.print.rspi_lv', compact('data', 'serial_no', 'start_date', 'end_date', 'supply_officer', 'accounting_staff'));       

    }
    
}
