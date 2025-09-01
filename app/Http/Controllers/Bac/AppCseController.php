<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyAppCseRequest;
use App\Http\Requests\StoreAppCseRequest;
use App\Http\Requests\UpdateAppCseRequest;
use App\Models\App;
use App\Models\AppCse;
use App\Models\Ppmp;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class AppCseController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('app_cse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $app_id = $request->id;
        $data = AppCse::all(); // Or find relevant data
        $finalized = App::where('id', $app_id)->value('finalized');
       
        return view('bac.app_cse.index', compact('app_id', 'data', 'finalized'));
    }

    public function getAppCses(Request $request)
    {            
        $app_id = $request->app_id;
       
        $appCseData = AppCse::with(['ppmp', 'app'])->where('app_id', $app_id)->orderBy('id', 'desc')->get();        
       
        // Use DataTables with the query
        return datatables()->of($appCseData)
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
        abort_if(Gate::denies('app_cse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->id;
        $ppmps = Ppmp::whereNull('app_id')->where('category', 'CSE')->orderBy('title', 'asc')->get();

        return view('bac.app_cse.create', compact('id', 'ppmps'));
    }

    public function store(StoreAppCseRequest $request)
    {
        abort_if(Gate::denies('app_cse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $id = $request->app_id;
        $data = $request->all();

        $ppmp = Ppmp::with('fund')->find($request->ppmp_id);
        $ppmp->app_id = $id;
        $ppmp->save();

        $appCse = AppCse::create($data);

        return redirect()->route('bac.app_cse.index', compact('id'));
    }

    public function show(AppCse $appCse)
    {
        abort_if(Gate::denies('app_cse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $appCse->load(['ppmp']);
        
        return view('bac.app_cse.show', compact('appCse'));
    }

    public function destroy(AppCse $appCse)
    {
        abort_if(Gate::denies('app_cse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ppmp = Ppmp::find($appCse->ppmp_id);
        $ppmp->app_id = null;
        $ppmp->save();

        $appCse->delete();

        return back();
    }
}

