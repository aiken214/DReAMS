<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRpciRequest;
use App\Http\Requests\StoreRpciRequest;
use App\Http\Requests\UpdateRpciRequest;
use App\Models\Rpci;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RpciController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rpci_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.rpci.index');
    }

    public function getRpci(Request $request)
    {            
        // Fetch data
        $start_date = $request->get('from');
        $end_date = $request->get('to');

        // Initialize query
        $query = Rpci::query();

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from . ' 00:00:00', $request->to . ' 23:59:59']);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $data = $query->get();

        $totalCost = $query->sum('unit_value'); // Calculate total cost
        // Use DataTables with the query
        return datatables($data)
            ->with('totalCost', $totalCost) // Add totalCost to the response
            ->make(true);     
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('rpci_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;    
        $units = Unit::all()->sortBy('unit');

        return view('supply.rpci.create', compact('id', 'units'));
    }

    public function store(StoreRpciRequest $request)
    {
        abort_if(Gate::denies('rpci_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
        
        $rpci = Rpci::create($data);

        return redirect()->route('supply.rpci.index');
    }

    public function edit(Rpci $rpci)
    {
        abort_if(Gate::denies('rpci_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
    
        $units = Unit::all()->sortBy('unit');

        return view('supply.rpci.edit', compact('rpci', 'units'));
    }

    public function update(UpdateRpciRequest $request, Rpci $rpci)
    {
        abort_if(Gate::denies('rpci_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $rpci->update($request->all());

        return redirect()->route('supply.rpci.index');
    }

    public function show(Rpci $rpci)
    {
        abort_if(Gate::denies('rpci_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('supply.rpci.show', compact('rpci'));
    }

    public function destroy(Rpci $rpci, $id)
    {
        abort_if(Gate::denies('rpci_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rpci = Rpci::find($id);
        $rpci->delete();

        return back();
    }
}
