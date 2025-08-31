<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIiruspItemRequest;
use App\Http\Requests\StoreIiruspItemRequest;
use App\Http\Requests\UpdateIiruspItemRequest;
use App\Models\Iirusp;
use App\Models\IiruspItem;
use App\Models\Rpcsp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class IiruspItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('iirusp_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $id = $request->id;

        return view('supply.iirusp_item.index', compact('id'));
    }

    public function getIiruspItems(Request $request)
    {              
        $id = $request->iirusp_id;   
       
        // Retrieve only data filtered by ics_hv_id
        $query = IiruspItem::where('iirusp_id', $id); 

        // Use DataTables query builder for better performance
        return datatables()->eloquent($query)->make(true); 
    }
      
    public function create(Request $request)
    {
        abort_if(Gate::denies('iirusp_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;

        return view('supply.iirusp_item.create', compact('id'));
    }

    public function store(StoreIiruspItemRequest $request)
    {
        $id = $request->iirusp_id;
        $data = $request->all();

        $iiruspItem = IiruspItem::create($data);

        return redirect()->route('supply.iirusp_item.index', compact('id'));
    }

    public function createFromRpcsp(Request $request, $id)
    {
        abort_if(Gate::denies('iirusp_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;
        $station_id = Iirusp::where('id', $id)->value('station_id');
        $rpcsps = Rpcsp::with(
            'ics_item_hv:id,ics_hv_id',
            'ics_item_hv.ics_hv:id,date,recipient'
            )->where('station_id', $station_id)->get();

        return view('supply.iirusp_item.create_from_rpcppe', compact('id', 'rpcsps'));
    }

    public function storeFromRpcppe(StoreIiruspItemRequest $request)
    {
        $id = $request->iirusp_id;
        $data = $request->all();

        $iiruspItem = IiruspItem::create($data);
        Rpcsp::where('id', $iiruspItem->rpcsp_id)->update(['iirusp_id' => $iiruspItem->id]); 

        return redirect()->route('supply.iirusp_item.index', compact('id'));
    }
    
    
    public function edit(IiruspItem $iiruspItem)
    {
        abort_if(Gate::denies('iirusp_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.iirusp_item.edit', compact('iiruspItem'));
    }

    public function update(UpdateIiruspItemRequest $request, IiruspItem $iiruspItem)
    {
        $id = $iiruspItem->iirusp_id;
 
        $iiruspItem->update($request->all());

        return redirect()->route('supply.iirusp_item.index', compact('id'));
    }  

    public function show(IiruspItem $iiruspItem)
    {
        abort_if(Gate::denies('iirusp_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.iirusp_item.show', compact('iiruspItem'));
    }  
}
