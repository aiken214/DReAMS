<?php

namespace App\Http\Controllers\Supply;

use App\Models\PurchaseRequest;
use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PrCheckedPrintController extends Controller
{
    public function print(Request $request, $from = null, $to = null)
    {
        $hope = Signatory::where('designation', "Head of Procuring Entity")->first();
        $budget_officer = Signatory::where('designation', "Budget Officer")->first();

        // Initialize query
        $query = PurchaseRequest::whereNotNull('finalized')->whereNotNull('checked')
                ->withSum('purchase_request_item as total_cost_sum', 'total_cost');
        
        // Apply filters
        if (!empty($from) && !empty($to)) {
            $query->whereBetween('created_at', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        // Fetch data
        $items = $query->get();

        return view('supply.print.purchase_request_checked', compact('items', 'hope', 'budget_officer', 'from', 'to'));
    }

}
