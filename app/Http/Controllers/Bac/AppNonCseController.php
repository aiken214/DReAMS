<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAppNonCseRequest;
use App\Http\Requests\StoreAppNonCseRequest;
use App\Http\Requests\UpdateAppNonCseRequest;
use App\Models\App;
use App\Models\AppNonCse;
use App\Models\Ppmp;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class AppNonCseController extends Controller
{
    public function index(Request $request )
    {
        abort_if(Gate::denies('app_non_cse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $app_id = $request->id;
        $data = AppNonCse::all(); // Or find relevant data
        $finalized = App::where('id', $app_id)->value('finalized');
     
        return view('bac.app_non_cse.index', compact('app_id', 'data', 'finalized'));
    }

    public function getAppNonCses(Request $request)
    {            
        $app_id = $request->app_id;
       
        $appNonCseData = AppNonCse::with(['ppmp', 'app'])->where('app_id', $app_id)->orderBy('id', 'desc')->get();        
       
        // Use DataTables with the query
        return datatables()->of($appNonCseData)
            ->editColumn('calendar_year', function($data){
                return optional($data->ppmp)->calendar_year ?? 'N/A';
            })
            ->editColumn('title', function ($data) {
                return '<span style="white-space:normal">' . e(optional($data->ppmp)->title ?? 'N/A') . '</span>';
            })
            ->editColumn('type', function($data){
                return optional($data->ppmp)->type ?? 'N/A';
            })
            ->editColumn('prepared_by', function($data){
                return optional($data->ppmp)->prepared_by ?? 'N/A';
            })
            ->editColumn('station', function($data){
                return optional($data->ppmp)->station ?? 'N/A';
            })
            ->editColumn('fund_source', function($data){
                return optional($data->ppmp)->fund_source ?? 'N/A';
            })
            ->editColumn('budget_alloc', function($data){
                return optional($data->ppmp)->budget_alloc ?? 'N/A';
            })
            ->editColumn('finalized', function($data){
                return optional($data->app)->finalized;
            })
            ->addIndexColumn()
            ->rawColumns(['title']) // Specify columns with raw HTML, if applicable
            ->make(true);   
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('app_non_cse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;
        $ppmps = Ppmp::whereNull('app_id')->where('category', 'Non-CSE')->orderBy('title', 'asc')->get();

        return view('bac.app_non_cse.create', compact('id', 'ppmps'));
    }

    public function store(StoreAppNonCseRequest $request)
    {
        abort_if(Gate::denies('app_non_cse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->app_id;
        $data = $request->all();

        $ppmp = Ppmp::with('fund')->find($request->ppmp_id);
        $ppmp->app_id = $id;
        $ppmp->save();

        $appNonCse = AppNonCse::create($data);

        return redirect()->route('bac.app_non_cse.index', compact('id'));
    }

    public function show(AppNonCse $appNonCse)
    {
        abort_if(Gate::denies('app_non_cse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $appNonCse->load(['ppmp']);
        
        return view('bac.app_non_cse.show', compact('appNonCse'));
    }

    public function destroy(AppNonCse $appNonCse)
    {
        abort_if(Gate::denies('app_non_cse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ppmp = Ppmp::find($appNonCse->ppmp_id);
        $ppmp->app_id = null;
        $ppmp->save();

        $appNonCse->delete();

        return back();
    }
}
