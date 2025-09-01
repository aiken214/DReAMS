<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIirupItemRequest;
use App\Http\Requests\StoreIirupItemRequest;
use App\Http\Requests\UpdateIirupItemRequest;
use App\Models\Iirup;
use App\Models\IirupItem;
use App\Models\Rpcppe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class IirupItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('iirup_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;
  
        return view('supply.iirup_item.index', compact('id'));
    }

    public function getIirupItems(Request $request)
    {              
        $id = $request->iirup_id;   
       
        // Retrieve only data filtered by ics_hv_id
        $query = IirupItem::where('iirup_id', $id); 

        // Use DataTables query builder for better performance
        return datatables()->eloquent($query)->make(true); 
    }
      
    public function create(Request $request)
    {
        abort_if(Gate::denies('iirup_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;

        return view('supply.iirup_item.create', compact('id'));
    }

    public function store(StoreIirupItemRequest $request)
    {
        abort_if(Gate::denies('iirup_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->iirup_id;
        $data = $request->all();

        $iirupItem = IirupItem::create($data);

        return redirect()->route('supply.iirup_item.index', compact('id'));
    }

    public function createFromRpcppe(Request $request, $id)
    {
        abort_if(Gate::denies('iirup_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;
        $station_id = Iirup::where('id', $id)->value('station_id');
        $rpcppes = Rpcppe::with(
            'par_item:id,par_id',
            'par_item.par:id,date,recipient'
            )->where('station_id', $station_id)->get();

        return view('supply.iirup_item.create_from_rpcppe', compact('id', 'rpcppes'));
    }

    public function storeFromRpcppe(StoreIirupItemRequest $request)
    {
        abort_if(Gate::denies('iirup_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->iirup_id;
        $data = $request->all();

        $iirupItem = IirupItem::create($data);
        Rpcppe::where('id', $iirupItem->rpcppe_id)->update(['iirup_id' => $iirupItem->id]); 

        return redirect()->route('supply.iirup_item.index', compact('id'));
    }
    
    
    public function edit(IirupItem $iirupItem)
    {
        abort_if(Gate::denies('iirup_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.iirup_item.edit', compact('iirupItem'));
    }

    public function update(UpdateIirupItemRequest $request, IirupItem $iirupItem)
    {
        abort_if(Gate::denies('iirup_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $id = $iirupItem->iirup_id;
 
        $iirupItem->update($request->all());

        return redirect()->route('supply.iirup_item.index', compact('id'));
    }  

    public function show(IirupItem $iirupItem)
    {
        abort_if(Gate::denies('iirup_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.iirup_item.show', compact('iirupItem'));
    }  
}
