<?php

namespace App\Http\Controllers\Supply;

use App\Models\Par;
use App\Models\ParItem;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ParPrintController extends Controller
{
    public function print($id)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $data= Par::where('id', $id)->first();
        $table_data = ParItem::where('par_id', $id)->get();
     
        return view('supply.print.par', compact('data', 'table_data', 'hope', 'supply_officer'));
        
    }
}
