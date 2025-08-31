<?php

namespace App\Http\Controllers\Supply;

use App\Models\Iirusp;
use App\Models\IiruspItem;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class IiruspPrintController extends Controller
{
    public function print($id)
    {
        // Fetch signatories
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $auditor = Signatory::where('designation', "Audit Team Leader")->first();
        
        // Initialize query
        $iiruspData = Iirusp::where('id', $id)->first();
        $items = IiruspItem::where('iirusp_id', $id)->get();
   
        return view('supply.print.iirusp', compact('items', 'hope', 'supply_officer', 'auditor', 'items', 'iiruspData'));
    }
}
