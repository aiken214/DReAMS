<?php

namespace App\Http\Controllers\Supply;

use App\Models\Ppmp;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PpmpCheckedPrintController extends Controller
{
    public function print(Request $request, $from = null, $to = null)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $budget_officer = Signatory::where('designation', "Budget Officer")->first();

        // Initialize query
        $query = Ppmp::whereNotNull('finalized')->whereNotNull('checked');
        
        // Apply filters
        if (!empty($from) && !empty($to)) {
            $query->whereBetween('created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        // Fetch data
        $items = $query->get();

        return view('supply.print.ppmp_checked', compact('items', 'hope', 'budget_officer', 'from', 'to'));
    }

}
