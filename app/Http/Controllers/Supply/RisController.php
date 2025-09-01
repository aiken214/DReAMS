<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRisRequest;
use App\Http\Requests\StoreRisRequest;
use App\Http\Requests\UpdateRisRequest;
use App\Models\Ris;
use App\Models\Iar;
use App\Models\IarItem;
use App\Models\Donation;
use App\Models\Asset;
use App\Models\StockCard;
use App\Models\SemiExpendableCard;
use App\Models\PropertyCard;
use App\Models\PurchaseOrder;
use App\Models\DavnorsysEmployee;
use App\Models\Position;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RisController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ris_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('supply.ris.index');
    }

    public function getRis(Request $request)
    {                     
        // Fetch data
       
        $data = Ris::with([
            'iar:id,iar_no,purchase_request_id',
            'iar.purchase_request:id,requested_by,designation,office,purpose',
            'donation:id,donation_no,requester,designation,office,purpose',
            'asset:id,asset_no,requester,designation,office,purpose',
            'purchase_request' => function ($query) {
                $query->addSelect([
                    'purchase_requests.id as purchase_request_id', // Alias to prevent conflict
                    'purchase_requests.requested_by', 
                    'purchase_requests.designation', 
                    'purchase_requests.office', 
                    'purchase_requests.purpose'
                ]);
            }
        ])->get();

        // Use DataTables with the query
        return datatables($data)
            ->editColumn('requisitioner', function ($row) { 
                if (!empty($row->iar_id)) {
                    if (empty($row->iar->purchase_request)){
                        return "{$row->purchase_request?->requested_by} <br> {$row->purchase_request?->designation} <br> {$row->purchase_request?->office}";
                    } else {
                        return "{$row->iar->purchase_request?->requested_by} <br> {$row->iar->purchase_request?->designation} <br> {$row->iar->purchase_request?->office}";
                    }
                } elseif (!empty($row->donation_id)) {
                    return "{$row->donation?->requester} <br> {$row->donation?->designation} <br> {$row->donation?->office}";
                } elseif (!empty($row->asset_id)) {
                    return "{$row->asset?->requester} <br> {$row->asset?->designation} <br> {$row->asset?->office}";
                }
                return 'No requisitioner found';
            })
            ->editColumn('purpose', function ($row) { 
                if (!empty($row->iar_id)) {
                    if (empty($row->iar->purchase_request)){
                        return $row->purchase_request?->purpose ?? 'No purpose found';
                    } else {
                        return $row->iar->purchase_request?->purpose ?? 'No purpose found';
                    }
                } elseif (!empty($row->donation_id)) {
                    return $row->donation?->purpose ?? 'No purpose found';
                } elseif (!empty($row->asset_id)) {
                    return $row->asset?->purpose ?? 'No purpose found';
                }
                return 'No purpose found';
            })
            ->editColumn('reference', function ($row) { 
                if (!empty($row->iar_id)) {
                    return $row->iar?->iar_no ?? 'No reference found';
                } elseif (!empty($row->donation_id)) {
                    return $row->donation?->donation_no ?? 'No reference found';
                } elseif (!empty($row->asset_id)) {
                    return $row->asset?->asset_no ?? 'No reference found';
                }
                return 'No reference found';
            })
            ->editColumn('recipient', function($row){
                return "{$row->recipient} <br> {$row->designation} <br> {$row->office}";
            })  
            
            ->rawColumns(['requisitioner', 'purpose', 'reference', 'recipient']) 
            ->make(true);

    }
   
    public function createFromIar()
    {
        abort_if(Gate::denies('ris_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $iars = Iar::with([
                'stocks:iar_id,balance_quantity', // Select only balance_quantity from stocks
                'semi_expendables:iar_id,balance_quantity', // Select only balance_quantity from semi_expendables
                'properties:iar_id,balance_quantity', // Select only balance_quantity from properties
                'purchase_order:id,purchase_request_id', // Select only required columns
                'purchase_order.purchase_request:id,requested_by,designation,office' // Select only the office column
            ])
            ->where(function ($query) {
                $query->whereHas('stocks', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                })->orWhereHas('semi_expendables', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                })->orWhereHas('properties', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                });
            })
            ->whereNull('purchase_request_id')
            ->select('id','iar_no','purchase_order_id')
            ->get();

            $employees = DavnorsysEmployee::select('id', 'fullname')->orderBy('fullname', 'asc')->get();
            $designations = Position::select('id', 'position')->orderBy('position', 'asc')->get();
            $stations = Station::select('id', 'station_name')->orderBy('station_name', 'asc')->get();

        return view('supply.ris.create_from_iar', compact('iars', 'employees', 'stations', 'designations'));
    }    
   
    public function createFromAsset()
    {
        abort_if(Gate::denies('ris_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $assets = Asset::with([
                'stocks:asset_id,balance_quantity', // Select only balance_quantity from stocks
                'semi_expendables:asset_id,balance_quantity', // Select only balance_quantity from semi_expendables
                'properties:asset_id,balance_quantity', // Select only balance_quantity from properties
            ])
            ->where(function ($query) {
                $query->whereHas('stocks', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                })->orWhereHas('semi_expendables', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                })->orWhereHas('properties', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                });
            })
            ->select('id','asset_no', 'purpose')
            ->get();
            
            $employees = DavnorsysEmployee::select('id', 'fullname')->orderBy('fullname', 'asc')->get();
            $designations = Position::select('id', 'position')->orderBy('position', 'asc')->get();
            $stations = Station::select('id', 'station_name')->orderBy('station_name', 'asc')->get();

        return view('supply.ris.create_from_asset', compact('assets', 'employees', 'stations', 'designations'));
    }
    
    public function createFromDonation()
    {
        abort_if(Gate::denies('ris_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $donations = Donation::with([
                'stocks:donation_id,balance_quantity', // Select only balance_quantity from stocks
                'semi_expendables:donation_id,balance_quantity', // Select only balance_quantity from semi_expendables
                'properties:donation_id,balance_quantity', // Select only balance_quantity from properties
            ])
            ->where(function ($query) {
                $query->whereHas('stocks', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                })->orWhereHas('semi_expendables', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                })->orWhereHas('properties', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                });
            })
            ->select('id','donation_no', 'purpose')
            ->get();
            
            $employees = DavnorsysEmployee::select('id', 'fullname')->orderBy('fullname', 'asc')->get();
            $designations = Position::select('id', 'position')->orderBy('position', 'asc')->get();
            $stations = Station::select('id', 'station_name')->orderBy('station_name', 'asc')->get();

        return view('supply.ris.create_from_donation', compact('donations', 'employees', 'stations', 'designations'));
    }

    public function createFromPettyCash()
    {
        abort_if(Gate::denies('ris_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $iars = Iar::with([
                'stocks:iar_id,balance_quantity', // Select only balance_quantity from stocks
                'semi_expendables:iar_id,balance_quantity', // Select only balance_quantity from semi_expendables
                'properties:iar_id,balance_quantity', // Select only balance_quantity from properties
                'purchase_request:id,requested_by,designation,office' // Select only the office column
            ])
            ->where(function ($query) {
                $query->whereHas('stocks', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                })->orWhereHas('semi_expendables', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                })->orWhereHas('properties', function ($q) {
                    $q->where('balance_quantity', '>', 0);
                });
            })
            ->whereNotNull('purchase_request_id')
            ->select('id','iar_no','purchase_request_id')
            ->get();

            $employees = DavnorsysEmployee::select('id', 'fullname')->orderBy('fullname', 'asc')->get();
            $designations = Position::select('id', 'position')->orderBy('position', 'asc')->get();
            $stations = Station::select('id', 'station_name')->orderBy('station_name', 'asc')->get();

        return view('supply.ris.create_from_petty_cash', compact('iars', 'employees', 'stations', 'designations'));
    }   

    public function store(StoreRisRequest $request)
    {
        abort_if(Gate::denies('ris_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
        $data['ris_no'] =  $this->generateRisNo();
    
        $ris = Ris::create($data);

        return redirect()->route('supply.ris.index');
    }

    private function generateRisNo()
    {
        $last_ris = Ris::where('ris_no', 'like', 'RIS%')->orderByDesc('ris_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'RIS';

        if (!$last_ris || !$last_ris->ris_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_ris->ris_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }    
    
    public function edit(Ris $ris, $id)
    {
        abort_if(Gate::denies('ris_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $ris = Ris::find($id); // Fetch RIS by ID

        if (!$ris) {
            abort(404, 'RIS not found'); // Return 404 if not found
        }

        $employees = DavnorsysEmployee::select('id', 'fullname')->orderBy('fullname', 'asc')->get();
        $designations = Position::select('id', 'position')->orderBy('position', 'asc')->get();
        $stations = Station::select('id', 'station_name')->orderBy('station_name', 'asc')->get();

        return view('supply.ris.edit', compact('ris', 'employees', 'stations', 'designations'));
    }

    public function update(UpdateRisRequest $request, Ris $ris, $id)
    {
        abort_if(Gate::denies('ris_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        
        $ris = Ris::findOrFail($id);
        $ris->update($request->all());

        return redirect()->route('supply.ris.index');
    }

    public function show(Ris $ris, $id)
    {
        abort_if(Gate::denies('ris_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ris = Ris::with([
            'iar:id,iar_no',
            'donation:id,donation_no,requester,designation,office,purpose',
            'asset:id,asset_no,requester,designation,office,purpose',
            'purchase_request:purchase_requests.id as purchase_request_id,requested_by,designation,office,purpose'
        ])->where('id', $id)->first();

        return view('supply.ris.show', compact('ris'));
    }

    public function destroy(Ris $ris, $id)
    {
        abort_if(Gate::denies('ris_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ris = Ris::find($id);
        $ris->delete();

        return back();
    }

}
