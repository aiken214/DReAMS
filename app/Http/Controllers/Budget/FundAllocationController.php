<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFundRequest;
use App\Http\Requests\StoreFundRequest;
use App\Http\Requests\UpdateFundRequest;
use App\Models\FundAllocation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class FundAllocationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fund_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user_id = Auth::user()->id;

        return view('budget.fund_allocation.index', compact('user_id'));
    }

    public function getFunds(Request $request)
    {            
        $user_id = $request->user_id;

        // Retrieve the user with their roles
        $user = User::with('roles')->where('id', $user_id)->first();

        if ($user && $user->roles->isNotEmpty()) {
            // Get the first role and its role_id from the pivot table
            $role_id = $user->roles->first()->pivot->role_id;
        } else {
            $role_id = null; // Handle cases where the user has no roles
        }

        if(($role_id == 1) || ($role_id == 4)){  
            $data = FundAllocation::get();
        }else{
            $data = FundAllocation::where('user_id', $user_id)->get();
        }

        return datatables($data)->make(true);   

    }

    public function create()
    {
        abort_if(Gate::denies('fund_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::all()->sortBy('name');

        return view('budget.fund_allocation.create', compact('users'));
    }

    public function store(StoreFundRequest $request)
    {
        $data = $request->all();
        $user = User::find($data['user_id']);
        $data['name'] = $user->name;
        $data['unobligated'] = $data['amount'];
       
        $fundAllocation = FundAllocation::create($data);

        return redirect()->route('budget.fund_allocation.index');
    }

    public function edit(FundAllocation $fundAllocation)
    {
        abort_if(Gate::denies('fund_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        $users = User::all()->sortBy('name');

        return view('budget.fund_allocation.edit', compact('fundAllocation', 'users'));
    }

    public function update(UpdateFundRequest $request, FundAllocation $fundAllocation)
    {
        $user = User::find($request['user_id']);
        $request['name'] = $user->name;
        $request['unobligated'] = $fundAllocation->amount - $fundAllocation->obligated;

        $fundAllocation->update($request->all());

        return redirect()->route('budget.fund_allocation.index');
    }

    public function show(FundAllocation $fundAllocation)
    {
        abort_if(Gate::denies('fund_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('budget.fund_allocation.show', compact('fundAllocation'));
    }

    public function massDestroy(MassDestroyPpmpRequest $request)
    {
        FundAllocation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
