<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIcsItemLvRequest;
use App\Http\Requests\StoreIcsItemLvRequest;
use App\Http\Requests\UpdateIcsItemLvRequest;
use App\Models\IcsHv;
use App\Models\IcsItemLv;
use App\Models\Ris;
use App\Models\RisItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class IcsItemLvController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('ics_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;

        return view('supply.ics_item_lv.index', compact('id'));
    }

    public function getIcsItemLv(Request $request)
    {            
        $id = $request->ics_lv_id;   

        // Retrieve only data filtered by ics_lv_id
        $query = IcsItemLv::where('ics_lv_id', $id); 

        // Use DataTables query builder for better performance
        return datatables()->eloquent($query)->make(true); 
    }

    public function edit(IcsItemLv $icsItemLv)
    {
        abort_if(Gate::denies('ics_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.ics_item_lv.edit', compact('icsItemLv'));
    }

    public function update(UpdateIcsItemLvRequest $request, IcsItemLv $icsItemLv)
    {
        abort_if(Gate::denies('ics_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $icsItemLv->ics_lv_id;
 
        $icsItemLv->update($request->all());

        return redirect()->route('supply.ics_item_lv.index', compact('id'));
    }  

    public function show(IcsItemLv $icsItemLv)
    {
        abort_if(Gate::denies('ics_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.ics_item_lv.show', compact('icsItemLv'));
    }  
}
