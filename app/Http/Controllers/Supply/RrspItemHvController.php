<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIcsItemHvRequest;
use App\Http\Requests\StoreIcsItemHvRequest;
use App\Http\Requests\UpdateIcsItemHvRequest;
use App\Models\RrspHv;
use App\Models\IcsHv;
use App\Models\IcsItemHv;
use App\Models\RrspItemHv;
use App\Models\Ris;
use App\Models\RisItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RrspItemHvController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('rrsp_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
   
        $id = $request->id;
        
        return view('supply.rrsp_item_hv.index', compact('id'));
    }

    public function getRrspItemHv(Request $request)
    {     
        $id = $request->rrsp_hv_id;   
        $rrsp = RrspHv::find($id);
       
        // Retrieve only data filtered by ics_hv_id
        $query = IcsItemHv::where('ics_hv_id', $rrsp->ics_hv_id); 

        // Use DataTables query builder for better performance
        return datatables()->eloquent($query)->make(true); 
    }
    
    public function show(RrspItemHv $rrspItemHv)
    {
        abort_if(Gate::denies('rrsp_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rrspHv = RrspHv::where('ics_hv_id', $rrspItemHv->ics_hv_id)->first();

        // Add the rrsp_hv_id if found
        if ($rrspHv) {
            $rrspItemHv->rrsp_hv_id = $rrspHv->id;
        }
        
        return view('supply.rrsp_item_hv.show', compact('rrspItemHv'));
    }  
}
