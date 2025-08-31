<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRsmiRequest;
use App\Http\Requests\StoreRsmiRequest;
use App\Http\Requests\UpdateRsmiRequest;
use App\Models\Rsmi;
use App\Models\Ris;
use App\Models\RisItem;
use App\Models\Iar;
use App\Models\IarItem;
use App\Models\Donation;
use App\Models\Asset;
use App\Models\StockCard;
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

class RsmiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rsmi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        return view('supply.rsmi.index');
    }

    public function getRsmis(Request $request)
    {            
             
        // Fetch data
        $data = Rsmi::with([
                'purchase_order:id,po_no,supplier_id',
                'purchase_order.iars:id,purchase_order_id', // Load IARs properly
                'purchase_order.supplier:id,name', // Load supplier name
                'donation:id,donation_no,reference,donor',
            ])->get();
    
        return datatables($data)
            ->editColumn('reference', function ($row) {
                if (!empty($row->purchase_order)) {
                    return $row->purchase_order->po_no ?? 'No reference found';
                } elseif (!empty($row->donation)) {
                    return $row->donation->donation_no ?? 'No reference found';
                } 
                return 'No reference found';
            })
            ->editColumn('amount', function ($row) {
                $iarIds = $row->purchase_order->iars->pluck('id')->toArray(); // Get an array of IAR IDs
        
                $amount = StockCard::whereIn('iar_id', $iarIds)
                    ->when($row->donation, function ($query) use ($row) {
                        return $query->orWhere('donation_id', $row->donation->id);
                    })
                    ->sum('amount');
        
                return number_format($amount, 2); // Format amount properly
            })
            ->editColumn('supplier', function ($row) {
                if (!empty($row->purchase_order)) {
                    return $row->purchase_order->supplier->name ?? 'No supplier found';
                } elseif (!empty($row->donation)) {
                    return $row->donation->donor ?? 'No donor found'; // Fixed incorrect reference
                } 
                return 'No supplier/donor found';
            })
            ->rawColumns(['reference', 'supplier']) // Specify columns with raw HTML, if applicable
            ->make(true);

    }

    public function create()
    {
        abort_if(Gate::denies('rsmi_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $zeroBalanceIds = StockCard::select('iar_id', 'donation_id')
            ->whereNull('rsmi_id') // Ensure rsmi_id is NULL
            ->groupBy('iar_id', 'donation_id')
            ->havingRaw('SUM(balance_quantity) = 0') // Get only records where total balance is 0
            ->get();

        // Separate IAR IDs and Donation IDs
        $iarIdsWithZeroBalance = $zeroBalanceIds->pluck('iar_id')->filter(); // Get only non-null iar_id
        $donationIdsWithZeroBalance = $zeroBalanceIds->pluck('donation_id')->filter(); // Get only non-null donation_id

        // Get POs that have at least one IAR with a non-zero balance (to exclude)
        $purchaseOrdersWithNonZeroIars = PurchaseOrder::whereHas('iars.stocks', function ($query) {
            $query->havingRaw('SUM(balance_quantity) > 0');
        })
        ->pluck('id'); // Get IDs of POs to exclude

        // Get POs where **all** IARs have zero balance
        $purchaseOrders = PurchaseOrder::whereHas('iars', function ($query) use ($iarIdsWithZeroBalance) {
            $query->whereIn('id', $iarIdsWithZeroBalance);
        })
        ->whereNotIn('id', $purchaseOrdersWithNonZeroIars) // Exclude POs with at least one non-zero IAR
        ->with('supplier:id,name') // Load supplier details (assuming 'name' exists in Supplier)
        ->select('id', 'po_no', 'supplier_id') // Include supplier_id
        ->get();
        
        // Get Donations where all stock cards have zero balance
        $donations = Donation::whereIn('id', $donationIdsWithZeroBalance)
        ->select('id', 'donation_no', 'donor')
        ->get();

        $mergedItems = $purchaseOrders->map(function ($purchaseOrder) {
            return [
                'id' => $purchaseOrder->id,
                'type' => 'PurchaseOrder',
                'number' => $purchaseOrder->po_no,
                'from' => $purchaseOrder->supplier->name,
            ];
        })->merge($donations->map(function ($donation) {
            return [
                'id' => $donation->id,
                'type' => 'Donation',
                'number' => $donation->donation_no,
                'from' => $donation->donor,
            ];
        }));

        return view('supply.rsmi.create', compact('mergedItems'));
    }

    public function store(StoreRsmiRequest $request)
    {
        $data = $request->all();
        $data['rsmi_no'] = $this->generateRsmiNo();

        if ($data['type'] === "PurchaseOrder") {  
            $data['purchase_order_id'] = $data['reference_id'];
            $rsmi = Rsmi::create($data);

            // Get all IAR IDs linked to the purchase order
            $iarIds = Iar::where('purchase_order_id', $data['purchase_order_id'])
                        ->pluck('id');

            // Update stock_cards where iar_id matches
            StockCard::whereIn('iar_id', $iarIds)->update(['rsmi_id' => $rsmi->id]);

        } elseif ($data['type'] === "Donation") {
            $data['donation_id'] = $data['reference_id'];
            $rsmi = Rsmi::create($data);

            // Update stock_cards where donation_id matches
            StockCard::where('donation_id', $data['donation_id'])
                    ->update(['rsmi_id' => $rsmi->id]);
        }

        return redirect()->route('supply.rsmi.index');
    }

    private function generateRsmiNo()
    {
        $last_rsmi = Rsmi::where('rsmi_no', 'like', 'RSMI%')->orderByDesc('rsmi_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'RSMI';

        if (!$last_rsmi || !$last_rsmi->rsmi_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_rsmi->rsmi_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }       

    public function edit(Rsmi $rsmi)
    {
        abort_if(Gate::denies('rsmi_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        return view('supply.rsmi.edit', compact('rsmi'));
    }

    public function update(UpdateRsmiRequest $request, Rsmi $rsmi)
    {
        $rsmi->update($request->all());

        return redirect()->route('supply.rsmi.index');
    }

    public function show(Rsmi $rsmi)
    {
        abort_if(Gate::denies('rsmi_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rsmi->load([
            'purchase_order:id,po_no,supplier_id',
            'purchase_order.iars:id,purchase_order_id', // Load IARs properly
            'purchase_order.supplier:id,name', // Load supplier name
            'donation:id,donation_no,reference,donor',
        ]);
     
        // Get an array of IAR IDs only if purchase_order exists
        $iarIds = optional($rsmi->purchase_order)->iars
            ? $rsmi->purchase_order->iars->pluck('id')->toArray()
            : [];

        $amount = StockCard::when(!empty($iarIds), function ($query) use ($iarIds) {
                return $query->whereIn('iar_id', $iarIds);
            })
            ->when($rsmi->donation, function ($query) use ($rsmi) {
                return $query->orWhere('donation_id', $rsmi->donation->id);
            })
            ->sum('amount');

        return view('supply.rsmi.show', compact('rsmi', 'amount'));
    }

    public function destroy(Rsmi $rsmi)
    {
        abort_if(Gate::denies('rsmi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        // Bulk update instead of looping
        StockCard::where('rsmi_id', $rsmi->id)->update(['rsmi_id' => null]);

        $rsmi->delete();

        return back();
    } 
}
