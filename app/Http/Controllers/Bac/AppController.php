<?php

namespace App\Http\Controllers\Bac;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAppRequest;
use App\Http\Requests\StoreAppRequest;
use App\Http\Requests\UpdateAppRequest;
use App\Models\App;
use App\Models\User;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class AppController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('app_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $user_id = Auth::user()->id;

        return view('bac.app.index', compact('user_id'));
    }

    public function getApps(Request $request)
    {            
        $user_id = $request->user_id;
        // Get the user and their roles
        $user = User::with('roles')->find($user_id);

        // Get station_id
        $station_id = $user->station_id;

        // Get user roles (array of role names)
        $roles = $user->roles->pluck('title')->toArray(); 
        
        if (array_intersect(['Admin', 'Bac'], $roles)) {           
            $data = App::all()->sortByDesc('id');
        } else {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'You do not have permission to access this resource.',
            ], 404);
        }
        
        return datatables($data)->make(true);   

    }

    public function create()
    {
        abort_if(Gate::denies('app_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('bac.app.create');
    }

    public function store(StoreAppRequest $request)
    {
        $data = $request->all();        
        $app = App::create($data);

        return redirect()->route('bac.app.index');
    }

    public function edit(App $app)
    {
        abort_if(Gate::denies('app_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('bac.app.edit', compact('app'));
    }

    public function update(UpdateAppRequest $request, App $app)
    {
        $app->update($request->all());

        return redirect()->route('bac.app.index');
    }

    public function show(App $app)
    {
        abort_if(Gate::denies('app_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('bac.app.show', compact('app'));
    }

    public function destroy(App $app)
    {
        abort_if(Gate::denies('app_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $app->delete();

        return back();
    }

    public function finalize(Request $request)
    {
        abort_if(Gate::denies('app_finalize'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $date = Carbon::now();
        $id = $request->id;
        $apps = App::findOrfail($id);
        $apps->finalized = $date;
        $apps->update(); 
    }

    public function revert(Request $request)
    {
        abort_if(Gate::denies('app_revert'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $request->id;
        $apps = App::findOrfail($id);
        $apps->finalized = null;
        $apps->update();  
    }
}



