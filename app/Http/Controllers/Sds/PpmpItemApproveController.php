<?php

namespace App\Http\Controllers\Sds;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\Ppmp;
use App\Models\PpmpItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PpmpItemApproveController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('ppmp_item_approve_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->id;
        $data = Ppmp::find($id);
        $sum_budget =  PpmpItem::where('ppmp_id', $id)->sum('budget');          
        $discrepancy = $data->budget_alloc - $sum_budget;

        return view('sds.ppmp_item_approve.index', compact('id', 'data', 'sum_budget', 'discrepancy'));
    }

    public function getPpmpItemsApprove(Request $request)
    {            
        $ppmp_id = $request->ppmp_id;
        
        $data = PpmpItem::with(['ppmp'])->where('ppmp_id', $ppmp_id)->get();
        
        return datatables($data)->make(true);   

    }
}
