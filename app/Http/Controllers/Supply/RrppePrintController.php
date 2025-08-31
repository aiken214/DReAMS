<?php

namespace App\Http\Controllers\Supply;

use App\Models\Rrppe;
use App\Models\Par;
use App\Models\ParItem;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class RrppePrintController extends Controller
{
    public function print($id)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        // Fetch data
        $data = Rrppe::with([
            'par:id,par_no,entity_name,recipient,designation',
            'par.par_item:id,par_id,description,quantity,remarks'
            ])
            ->where('id', $id)
            ->orderBy('id', 'asc')->first();

        return view('supply.print.rrppe', compact('data', 'hope', 'supply_officer'));
    }

}
