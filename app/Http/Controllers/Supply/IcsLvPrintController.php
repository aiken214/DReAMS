<?php

namespace App\Http\Controllers\Supply;

use App\Models\IcsLv;
use App\Models\IcsItemLv;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class IcsLvPrintController extends Controller
{
    public function print($id)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $data= IcsLv::where('id', $id)->first();
        $table_data = IcsItemLv::where('ics_lv_id', $id)->get();
        $title_value = 'Low Value';
        
        return view('supply.print.ics', compact('data', 'table_data', 'hope', 'supply_officer', 'title_value'));
    }
}
