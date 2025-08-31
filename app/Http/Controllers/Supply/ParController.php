<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyParRequest;
use App\Http\Requests\StoreParRequest;
use App\Http\Requests\UpdateParRequest;
use App\Models\Par;
use App\Models\ParItem;
use App\Models\Ris;
use App\Models\RisItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ParController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('par_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.par.index');
    }

    public function getPars(Request $request)
    {            
        // Fetch data
        $data = Par::with(['ris:id,ris_no'])
            ->orderBy('id', 'asc')->get();

        // Use DataTables with the query
        return datatables($data)
            ->editColumn('reference', function ($row) {
                return $row->ris->ris_no;
            })
            ->make(true);   
    }

    public function create()
    {
        abort_if(Gate::denies('par_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $risData = Ris::whereHas('ris_item', function ($query) {
                $query->where('category', 'PPE')
                    ->whereNull('status');
            })
            ->with('ris_item') // Load related ris_item after filtering
            ->get();

        return view('supply.par.create', compact('risData'));
    }

    public function store(StoreParRequest $request)
    {
        $id = $request->ris_id;
        
        // Get RIS items under the given RIS ID with category HVSE
        $risItems = RisItem::where('ris_id', $id)
            ->where('category', 'PPE')
            ->with(['properties:id,unit_price']) // Select only id and unit_price
            ->get();

        // Check if RIS items exist
        if ($risItems->isEmpty()) {
            return redirect()->back()->with('error', 'No PPE items found for this RIS.');
        }

        foreach ($risItems as $item) {
            // Ensure issued_quantity is valid
            $issuedQuantity = (int) $item->issued_quantity;
            
            if ($issuedQuantity <= 0) {
                continue; // Skip items with no issued quantity
            }       
            
            for ($i = 0; $i < $issuedQuantity; $i++) {  
                // Create only one ICS HV Entry per RIS
                $data = $request->all();
                $data['par_no'] = $this->generateParNo();
                $par = Par::create($data);

                $parItem = new ParItem;
                $parItem->quantity = 1;            
                $parItem->unit = $item->unit;
                $parItem->amount = $item->properties->unit_price;
                $parItem->description = $item->description;
                $parItem->ris_item_id = $item->id;
                $parItem->par_id = $par->id;
                $parItem->property_card_id = $item->property_card_id;
                $parItem->property_no = $this->generatePropertyNo();
                $parItem->save();    
            }
        
            // Update RIS Item status
            $item->status = "PAR Generated";
            $item->save();
        }

        return redirect()->route('supply.par.index')->with('success', 'PAR successfully generated.');
    }
    
    private function generateParNo()
    {
        $last_par = Par::where('par_no', 'like', 'PAR%')->orderByDesc('par_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'PAR';

        if (!$last_par || !$last_par->par_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_par->par_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }   

    private function generatePropertyNo()
    {
        $last_pro = ParItem::where('property_no', 'like', 'PN%')->orderByDesc('property_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'PN';

        if (!$last_pro || !$last_pro->property_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_pro->property_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }

    public function edit(Par $par)
    {
        abort_if(Gate::denies('par_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.par.edit', compact('par'));
    }

    public function update(UpdateParRequest $request, Par $par)
    {
        $par->update($request->all());

        return redirect()->route('supply.par.index');
    }  

    public function show(Par $par)
    {
        abort_if(Gate::denies('par_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $par->load([
            'ris:id,ris_no', 
        ]);

        return view('supply.par.show', compact('par'));
    }  
}
