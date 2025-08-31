<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\App;
use App\Models\Ppmp;
use App\Models\AppItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AppPrintController extends Controller
{
    public function app_print($id)
    {

        $app_data = App::find($id);                   
        $app_item_data = DB::table('app_items')->where('app_id', $id)->orderBy('id','asc')->get();
        $bac_chair = DB::table('signatories')->where('designation', '=' , "BAC Chairperson")->first();
        $bac_vice_chair = DB::table('signatories')->where('designation', "BAC Member")->where('role', "Vice-Chair - BAC")->first();
        $bac_member = DB::table('signatories')->where('designation', "BAC Member")->where('role', "Member - BAC")->get();
        $hope = DB::table('signatories')->where('designation', "Head of Procuring Entity")->first();
        $bac_sec = DB::table('signatories')->where('designation', "BAC Secretariate")->where('role', "Head")->first();

        return view('bac.print.app', compact('app_data', 'app_item_data', 'bac_chair', 'bac_member', 'bac_sec', 'hope', 'bac_vice_chair'));
        
    }

    public function app_cse_print($id)
    {
        $appData = App::find($id);
        $ppmpData = Ppmp::with(['ppmp_item'])->where('app_id', $id)->get();   
        $end_user = DB::table('signatories')->where('designation', '=' , "Supply Officer")->first();
        // Correct way to sum the 'budget' column from 'ppmp_item'
        $sum_budget = $ppmpData->flatMap->ppmp_item->sum('budget');     
        $budget_officer = DB::table('signatories')->where('designation', '=' , "Budget Officer")->first();
        $hope = DB::table('signatories')->where('designation', '=' , "Head of Procuring Entity")->first();
        
        return view('bac.print.app_cse', compact('ppmpData', 'appData', 'end_user', 'sum_budget', 'budget_officer', 'hope'));
        
    }

    public function app_non_cse_print($id)
    {
        $appData = App::find($id);
        $ppmpData = Ppmp::with(['ppmp_item'])->where('app_id', $id)->get();   
        $end_user = DB::table('signatories')->where('designation', '=' , "Supply Officer")->first();
        // Correct way to sum the 'budget' column from 'ppmp_item'
        $sum_budget = $ppmpData->flatMap->ppmp_item->sum('budget');     
        $budget_officer = DB::table('signatories')->where('designation', '=' , "Budget Officer")->first();
        $hope = DB::table('signatories')->where('designation', '=' , "Head of Procuring Entity")->first();
        
        return view('bac.print.app_non_cse', compact('ppmpData', 'appData', 'end_user', 'sum_budget', 'budget_officer', 'hope'));
        
    }
   
}

