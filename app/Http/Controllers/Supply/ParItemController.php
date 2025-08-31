<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyParItemRequest;
use App\Http\Requests\StoreParItemRequest;
use App\Http\Requests\UpdateParItemRequest;
use App\Models\Par;
use App\Models\ParItem;
use App\Models\Ris;
use App\Models\RisItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ParItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('par_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;

        return view('supply.par_item.index', compact('id'));
    }

    public function getParItems(Request $request)
    {            
        $id = $request->par_id;   

        // Retrieve only data filtered by ics_hv_id
        $query = ParItem::where('par_id', $id); 

        // Use DataTables query builder for better performance
        return datatables()->eloquent($query)->make(true); 
    }
    
    public function edit(ParItem $parItem)
    {
        abort_if(Gate::denies('par_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.par_item.edit', compact('parItem'));
    }

    public function update(UpdateParItemRequest $request, ParItem $parItem)
    {
        $id = $parItem->par_id;
 
        $parItem->update($request->all());

        return redirect()->route('supply.par_item.index', compact('id'));
    }  

    public function show(ParItem $parItem)
    {
        abort_if(Gate::denies('par_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.par_item.show', compact('parItem'));
    }  
}
