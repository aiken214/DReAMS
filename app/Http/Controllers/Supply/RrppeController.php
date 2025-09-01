<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRrppeRequest;
use App\Http\Requests\StoreRrppeRequest;
use App\Http\Requests\UpdateRrppeRequest;
use App\Models\Rrppe;
use App\Models\Par;
use App\Models\ParItem;
use App\Models\Regppei;
use App\Models\PropertyCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RrppeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rrppe_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.rrppe.index');
    }

    public function getRrppe(Request $request)
    {            
        // Fetch data
        $data = Rrppe::with([
            'par:id,par_no,entity_name,recipient,designation',
            'par.par_item:id,par_id,remarks'
            ])
            ->orderBy('id', 'asc')->get();

        // Use DataTables with the query
        return datatables($data)->make(true);   
    }

    public function create()
    {
        abort_if(Gate::denies('rrppe_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pars = Par::with(['par_item' => function ($query) {
            $query->where('status', 'Issued')
                  ->orWhereNull('status'); // Include items with NULL status
        }])
        ->whereHas('par_item', function ($query) {
            $query->where('status', 'Issued')
                  ->orWhereNull('status');
        })
        ->get();

        return view('supply.rrppe.create', compact('pars'));
    }

    public function store(StoreRrppeRequest $request)
    {
        abort_if(Gate::denies('rrppe_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $par_id = $request->par_id;
        $data = $request->all();
        $data['rrppe_no'] =  $this->generateRrppeNo();       

        Par::where('id', $par_id)->update(['status' => "Returned"]);
        ParItem::where('par_id', $par_id)->update([
            'status' => "Returned",
            'serviceability' => $request->serviceability,
            'remarks' => "Item returned on {$request->date}",
        ]); 
        $parItem = ParItem::where('par_id', $par_id)->first();
        PropertyCard::where('id', $parItem->property_card_id)->update([
            'balance_quantity' => DB::raw("balance_quantity + {$parItem->quantity}"),
            'issued_quantity' => DB::raw("issued_quantity - {$parItem->quantity}"),
        ]);
        
        $rrppe = Rrppe::create($data);

        //save rspi
        $regPpeiData = [
            'date' => $rrppe->date, 
            'reference' => $rrppe->rrppe_no,                     
            'rrppe_id' => $rrppe->id, 
            ];
        Regppei::create($regPpeiData);

        return redirect()->route('supply.rrppe.index');
    }
    
    private function generateRrppeNo()
    {
        $last_rrppe = Rrppe::where('rrppe_no', 'like', 'RRPPE%')->orderByDesc('rrppe_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'RRPPE';

        if (!$last_rrppe || !$last_rrppe->rrppe_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_rrppe->rrppe_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }

    public function edit(Rrppe $rrppe)
    {
        abort_if(Gate::denies('rrppe_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        // Eager load the relationships on the single $Rrppe instance
        $rrppe->load([
            'par:id,par_no,entity_name,recipient,designation',
            'par.par_item:id,par_id,serviceability,remarks'
        ]);

        return view('supply.rrppe.edit', compact('rrppe'));
    }

    public function update(UpdateRrppeRequest $request, Rrppe $rrppe)
    {
        abort_if(Gate::denies('rrppe_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $par_id = $rrppe->par_id;        
        ParItem::where('par_id', $par_id)->update([
            'serviceability' => $request->serviceability,
        ]); 

        $rrppe->update($request->all());

        return redirect()->route('supply.rrppe.index');
    }   
    
    public function show(Rrppe $rrppe)
    {
        abort_if(Gate::denies('rrppe_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $rrppe->load('par');

        return view('supply.rrppe.show', compact('rrppe'));
    }  

    public function destroy(Rrppe $rrppe)
    {
        abort_if(Gate::denies('rrppe_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $par_id = $rrppe->par_id;        
        ParItem::where('par_id', $par_id)->update([
            'status' => null,
            'serviceability' => null,
        ]); 

        $rrppe->delete();

        return back();
    }

}
