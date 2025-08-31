<?php

namespace App\Http\Controllers\Supply;

use App\Models\IcsHv;
use App\Models\IcsItemHv;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class IcsHvPrintController extends Controller
{
    public function print($id)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $data= IcsHv::where('id', $id)->first();
        $table_data = IcsItemHv::where('ics_hv_id', $id)->get();
        $title_value = 'High Value';

        return view('supply.print.ics', compact('data', 'table_data', 'hope', 'supply_officer', 'title_value'));
    }

    public function print_consol($id)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        // $data= IcsHv::where('id', $id)->first();
        $risId = IcsHv::where('id', $id)->value('ris_id');
        $table_data = IcsHv::with('ics_item_hv', 'ris:id,ris_no')->where('ris_id', $risId)->get();
        // dd($icsHv);
        $title_value = 'High Value';

        return view('supply.print.ics_consol', compact('table_data', 'hope', 'supply_officer', 'title_value'));
    }
}
