<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPpmpItemRequest;
use App\Http\Requests\StorePpmpItemRequest;
use App\Http\Requests\UpdatePpmpItemRequest;
use App\Models\Ppmp;
use App\Models\PpmpItem;
use App\Models\ItemsList;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PpmpItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('ppmp_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->id;
        $data = Ppmp::find($id);
        $sum_budget =  PpmpItem::where('ppmp_id', $id)->sum('budget');          
        $discrepancy = $data->budget_alloc - $sum_budget;

        return view('user.ppmp_item.index', compact('id', 'data', 'sum_budget', 'discrepancy'));
    }

    public function getPpmpItems(Request $request)
    {            
        $ppmp_id = $request->ppmp_id;
        
        $data = PpmpItem::with(['ppmp'])->where('ppmp_id', $ppmp_id)->get();
        // if($user_id == 1){            
        //     $data = Ppmp::all()->sortByDesc('id');
        // }else{
        //     $data = Ppmp::where('station_id', $station_id)->get();
        // }  
        
        return datatables($data)->make(true);   

    }
    
    public function create(Request $request)
    {
        abort_if(Gate::denies('ppmp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
  
        $id = $request->id;
        $items = ItemsList::all()->sortBy('description');
        $units = Unit::all()->sortBy('unit');

        return view('user.ppmp_item.create', compact('id', 'items', 'units'));
    }

    public function store(StorePpmpItemRequest $request)
    {
        abort_if(Gate::denies('ppmp_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $data = $request->all();
        $id = $request->ppmp_id;        
        $data['balance'] = $data['quantity'];
        
        $ppmp_item = PpmpItem::create($data);

        return redirect()->route('user.ppmp_item.index', compact('id'));
    }
    
    public function edit(PpmpItem $ppmp_item)
    {
        abort_if(Gate::denies('ppmp_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $units = Unit::all()->sortBy('unit');

        return view('user.ppmp_item.edit', compact('ppmp_item', 'units'));
    }

    public function update(UpdatePpmpItemRequest $request, PpmpItem $ppmp_item)
    {
        abort_if(Gate::denies('ppmp_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $id = $ppmp_item->ppmp_id;
        $ppmp_item->update($request->all());        

        return redirect()->route('user.ppmp_item.index', compact('id'));
    }

    public function show(PpmpItem $ppmp_item)
    {
        abort_if(Gate::denies('ppmp_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('user.ppmp_item.show', compact('ppmp_item'));
    }
    
    public function destroy(PpmpItem $ppmp_item)
    {
        abort_if(Gate::denies('ppmp_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ppmp_item->delete();

        return back();
    }

    public function massDestroy(MassDestroyPpmpItemRequest $request)
    {
        abort_if(Gate::denies('ppmp_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        PpmpItem::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
