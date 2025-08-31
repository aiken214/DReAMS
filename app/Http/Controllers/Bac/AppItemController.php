<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAppItemRequest;
use App\Http\Requests\StoreAppItemRequest;
use App\Http\Requests\UpdateAppItemRequest;
use App\Models\AppItem;
use App\Models\Ppmp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class AppItemController extends Controller
{
    public function index(Request $request )
    {
        abort_if(Gate::denies('app_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $app_id = $request->id;
        $data = AppItem::first(); // Or find relevant data

        return view('bac.app_item.index', compact('app_id', 'data'));
    }

    public function getAppItems(Request $request)
    {            
        $app_id = $request->app_id;
       
        $data = AppItem::where('app_id', $app_id)->orderBy('id', 'desc')->get();        
        
        // Use DataTables with the query
        return datatables($data)
            ->editColumn('ppmp', function ($row) {
                return '<span style="white-space:normal">' . e($row->ppmp) . '</span>';
            })
            ->editColumn('remarks', function ($row) {
                return '<span style="white-space:normal">' . e($row->remarks) . '</span>';
            })
            ->rawColumns(['ppmp', 'remarks']) // Specify columns with raw HTML, if applicable
            ->make(true);   
        
        return datatables($data)->make(true);   

    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('app_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;
        $ppmps = Ppmp::whereNull('app_id')->where('category', '=', 'Competitive Bidding')->orderBy('title', 'asc')->get();

        return view('bac.app_item.create', compact('id', 'ppmps'));
    }

    public function store(StoreAppItemRequest $request)
    {
        $id = $request->app_id;
        $data = $request->all();
        
        $ppmp = Ppmp::with('fund')->find($request->ppmp_id);

        $data['fund_source'] =  trim(($ppmp->fund->fund_source ?? '') . ' ' . ($ppmp->fund_source ?? ''));
        $data['code'] = $ppmp->fund->ppa;
        $data['ppmp'] = $ppmp->title;  
            if($ppmp->fund->fund_source === 'Division MOOE') { 
                $data['mooe_budget'] = $ppmp->amount;
            } else {
                $data['co_budget'] = $ppmp->amount;
            }
        $appItem = AppItem::create($data);

            if ($ppmp) {
                $ppmp->app_id = $id; // Assign new value
                $ppmp->save(); // Save the changes
            } else {
                return response()->json(['message' => 'Purchase Request Item not found'], 404);
            } 
        
        return redirect()->route('bac.app_item.index', compact('id'));
    }

    public function edit(AppItem $appItem)
    {
        abort_if(Gate::denies('app_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('bac.app_item.edit', compact('appItem'));
    }

    public function update(UpdateAppItemRequest $request, AppItem $appItem)
    {
        $appItem->update($request->all());
        $id = $request->app_id;

        return redirect()->route('bac.app_item.index', compact('id'));
    }

    public function show(AppItem $appItem)
    {
        abort_if(Gate::denies('app_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('bac.app_item.show', compact('appItem'));
    }

    public function destroy(AppItem $appItem)
    {
        abort_if(Gate::denies('app_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ppmp = Ppmp::where('app_id', $appItem->id)->first();
        $ppmp->app_id = null;
        $ppmp->update(); 

        $appItem->delete();

        return back();
    }
}