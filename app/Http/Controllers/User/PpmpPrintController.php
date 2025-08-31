<?php

namespace App\Http\Controllers\User;

use App\Models\User\Item;
use App\Models\Ppmp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PpmpPrintController extends Controller
{
    public function print($id)
    {
        
        $data = Ppmp::find($id);        
        $items = DB::table('ppmp_items')->where('ppmp_id', $id)->where('deleted_at', '=', null)->orderBy('description','asc')->paginate(100);
        $end_user = DB::table('ppmps')->where('id', $id)->first();
        $sum_budget =  DB::table('ppmp_items')->where('ppmp_id', $id)->sum('budget');        
        $budget_officer = DB::table('signatories')->where('designation', '=' , "Budget Officer")->first();
        $hope = DB::table('signatories')->where('designation', '=' , "Head of Procuring Entity")->first();

        return view('user.print.ppmp', compact('data', 'items', 'end_user', 'budget_officer', 'hope', 'sum_budget'));

    }  
}
