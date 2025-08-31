<?php

namespace App\Http\Controllers\Supply;

use App\Models\Rpci;
use App\Models\Employee;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RpciPrintController extends Controller
{
    public function print(Request $request, $from = null, $to = null, $type = null)
    {        
        // Fetch signatories
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $supply_officer = Signatory::where('designation', "Supply Officer")->first();
        $auditor = Signatory::where('designation', "Audit Team Leader")->first();

        // Initialize query
        $query = Rpci::query();

        // Apply filters
        if (!empty($from) && !empty($to)) {
            $query->whereBetween('created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
            $asOf = date('F d, Y', strtotime($to));
        }

        if (!empty($type)) {
            $query->where('type', $type);
        } 

        // Fetch data
        $items = $query->get();
        $totalCost = $items->sum('unit_value'); // Calculate total cost

        return view('supply.print.rpci', compact('items', 'hope', 'supply_officer', 'auditor', 'type', 'asOf', 'totalCost'));
    }
}
