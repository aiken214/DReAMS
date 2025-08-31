<?php

namespace App\Http\Controllers\Supply;

use App\Models\RrspHv;
use App\Models\RrspLv;
use App\Models\RrspItemLv;
use App\Models\IcsHv;
use App\Models\IcsItemHv;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class RrspPrintController extends Controller
{
    public function print_hv($id)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $data = RrspHv::with([
            'ics_hv:id,ics_hv_no,entity_name,recipient,designation',
            'ics_hv.ics_item_hv:id,ics_hv_id,description,quantity,remarks'
            ])
            ->where('id', $id)
            ->orderBy('id', 'asc')->first();
        
        return view('supply.print.rrsp_hv', compact('data', 'hope', 'supply_officer'));
    }

    public function print_lv($id)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $rrspData = RrspLv::with([
            'ics_lv:id,ics_lv_no,entity_name,recipient,designation',
            ])
            ->where('id', $id)
            ->orderBy('id', 'asc')->first();
        
        $items = RrspItemLv::where('rrsp_lv_id', $id)->orderBy('id', 'asc')->get();

        return view('supply.print.rrsp_lv', compact('rrspData', 'items', 'hope', 'supply_officer'));
    }
}
