<?php

namespace App\Http\Controllers\Supply;

use App\Models\Iirup;
use App\Models\IirupItem;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class IirupPrintController extends Controller
{
    public function print($id)
    {
        // Fetch signatories
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $auditor = Signatory::where('designation', "Audit Team Leader")->first();
        
        // Initialize query
        $iirupData = Iirup::where('id', $id)->first();
        $items = IirupItem::where('iirup_id', $id)->get();
   
        return view('supply.print.iirup', compact('items', 'hope', 'supply_officer', 'auditor', 'items', 'iirupData'));
    }
}
