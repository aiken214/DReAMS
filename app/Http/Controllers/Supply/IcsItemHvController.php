<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIcsItemHvRequest;
use App\Http\Requests\StoreIcsItemHvRequest;
use App\Http\Requests\UpdateIcsItemHvRequest;
use App\Models\IcsHv;
use App\Models\IcsItemHv;
use App\Models\Ris;
use App\Models\RisItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class IcsItemHvController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('ics_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;
        $risId = IcsHv::where('id', $id)->value('ris_id');
        $risCount = IcsHv::where('ris_id', $risId)->count();
        
        return view('supply.ics_item_hv.index', compact('id', 'risCount'));
    }

    public function getIcsItemHv(Request $request)
    {            
        $id = $request->ics_hv_id;   

        // Retrieve only data filtered by ics_hv_id
        $query = IcsItemHv::where('ics_hv_id', $id); 

        // Use DataTables query builder for better performance
        return datatables()->eloquent($query)->make(true); 
    }

    public function edit(IcsItemHv $icsItemHv)
    {
        abort_if(Gate::denies('ics_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.ics_item_hv.edit', compact('icsItemHv'));
    }

    public function update(UpdateIcsItemHvRequest $request, IcsItemHv $icsItemHv)
    {
        abort_if(Gate::denies('ics_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $id = $icsItemHv->ics_hv_id;
 
        $icsItemHv->update($request->all());

        return redirect()->route('supply.ics_item_hv.index', compact('id'));
    }  

    public function show(IcsItemHv $icsItemHv)
    {
        abort_if(Gate::denies('ics_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        return view('supply.ics_item_hv.show', compact('icsItemHv'));
    }  
}
