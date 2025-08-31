<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySignatoryRequest;
use App\Http\Requests\StoreSignatoryRequest;
use App\Http\Requests\UpdateSignatoryRequest;
use App\Models\Signatory;
use App\Models\Position;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SignatoryController extends Controller
{
    use CsvImportTrait; 

    public function index()
    {
        abort_if(Gate::denies('signatory_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('admin.signatory.index');
    }

    public function getSignatories(Request $request)
    {                
        $data = Signatory::all()->sortBy('fullname');
        
        return datatables($data)->make(true);   
    }

    public function create()
    {
        abort_if(Gate::denies('signatory_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $positions = Position::all()->sortBy('position');

        return view('admin.signatory.create', compact('positions'));
    }

    public function store(StoreSignatoryRequest $request)
    {
        $signatories = Signatory::create($request->all());

        return redirect()->route('admin.signatory.index');
    }

    public function edit(Signatory $signatory)
    {
        abort_if(Gate::denies('signatory_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $positions = Position::all()->sortBy('position');

        return view('admin.signatory.edit', compact('signatory', 'positions'));
    }

    public function update(UpdateSignatoryRequest $request, Signatory $signatory)
    {
        $signatory->update($request->all());

        return redirect()->route('admin.signatory.index');
    }

    public function destroy(Signatory $signatory)
    {
        abort_if(Gate::denies('signatory_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $signatory->delete();

        return back();
    }

    public function massDestroy(MassDestroySignatoryRequest $request)
    {
        Signatory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
