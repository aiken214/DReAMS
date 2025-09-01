<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyItemsListRequest;
use App\Http\Requests\StoreItemsListRequest;
use App\Http\Requests\UpdateItemsListRequest;
use App\Models\ItemsList;
use App\Models\Unit;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ItemsListController extends Controller
{
    use CsvImportTrait; 

    public function index()
    {
        abort_if(Gate::denies('items_list_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('admin.items_list.index');
    }

    public function getItemsLists(Request $request)
    {                
    
        $data = ItemsList::all()->sortBy('description');
        
        return datatables($data)->make(true);   

    }

    public function create()
    {
        abort_if(Gate::denies('items_list_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = Unit::all()->sortBy('unit');

        return view('admin.items_list.create', compact('units'));
    }

    public function store(StoreItemsListRequest $request)
    {
        abort_if(Gate::denies('items_list_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items_list = ItemsList::create($request->all());

        return redirect()->route('admin.items_list.index');
    }

    public function edit(ItemsList $items_list)
    {
        abort_if(Gate::denies('items_list_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $units = Unit::all()->sortBy('unit');

        return view('admin.items_list.edit', compact('items_list', 'units'));
    }

    public function update(UpdateItemsListRequest $request, ItemsList $items_list)
    {
        abort_if(Gate::denies('items_list_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $items_list->update($request->all());

        return redirect()->route('admin.items_list.index');
    }

    public function show(ItemsList $items_list)
    {
        abort_if(Gate::denies('items_list_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.items_list.show', compact('items_list'));
    }
    
    public function destroy(ItemsList $items_list)
    {
        abort_if(Gate::denies('items_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items_list->delete();

        return back();
    }

    public function massDestroy(MassDestroyItemsListRequest $request)
    {
        abort_if(Gate::denies('items_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        ItemsList::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

