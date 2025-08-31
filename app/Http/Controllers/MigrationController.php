<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPrRequest;
use App\Http\Requests\StorePrRequest;
use App\Http\Requests\UpdatePrRequest;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\PpmpItem;
use App\Models\User;
use App\Models\Station;
use App\Models\Ppmp;
use App\Models\FundAllocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

use App\Models\ProcsysPr;

class MigrationController extends Controller
{

    public function migration_dashboard()
    {
        abort_if(Gate::denies('iar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('migration.dashboard');
    }

    public function purchase_request_migration()
    {
        abort_if(Gate::denies('purchase_request_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('migration.purchase_request');
    }

    public function getMigratePurchaseRequests(Request $request)
    {            
        // $data = ProcsysPr::all()->sortByDesc('id');
        $data = DB::connection('procsys')->table('purchase_requests')->get();
    
        
        return datatables($data)->make(true);   

    }

    public function purchase_request_migration_execute()
    {
        DB::beginTransaction();

        try {
            $oldRequests = DB::connection('procsys')->table('purchase_requests')->get();

            $migrated = 0;
            $skipped = 0;

            foreach ($oldRequests as $oldRequest) {
                // Skip if already migrated
                $alreadyMigrated = DB::table('purchase_requests')
                    ->where('old_pr_id', $oldRequest->id)
                    ->exists();

                if ($alreadyMigrated) {
                    $skipped++;
                    continue;
                }

                $newRequestId = DB::table('purchase_requests')->insertGetId([
                    'pr_no' => $oldRequest->pr_no,
                    'date' => $oldRequest->date,
                    'res_code' => $oldRequest->res_code,
                    'office' => $oldRequest->office,
                    'fund_cluster' => $oldRequest->fund_cluster,
                    'fund_source' => $oldRequest->fund_source,
                    'purpose' => $oldRequest->purpose,
                    'requested_by' => $oldRequest->requested_by,
                    'designation' => $oldRequest->designation,
                    'finalized' => $oldRequest->finalized,
                    'checked' => $oldRequest->checked,
                    'pre_check' => $oldRequest->pre_check,
                    'verified' => $oldRequest->verified,
                    'approved' => $oldRequest->approved,
                    'remarks' => $oldRequest->remarks,
                    'created_at' => $oldRequest->created_at,
                    'updated_at' => $oldRequest->updated_at,
                    'petty_cash_iar_id' => $oldRequest->petty_cash_iar,
                    'old_pr_id' => $oldRequest->id,
                ]);

                $oldItems = DB::connection('procsys')->table('pur_req_items')
                    ->where('pur_req_id', $oldRequest->id)
                    ->get();

                foreach ($oldItems as $item) {
                    DB::table('purchase_request_items')->insert([
                        'purchase_request_id' => $newRequestId,
                        'stock_no' => $item->stock_no,
                        'description' => $item->description,
                        'quantity' => $item->quantity,
                        'unit' => $item->unit,
                        'unit_price' => $item->unit_price,
                        'total_cost' => $item->total_cost,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'old_purchase_request_item_id' => $item->id, 
                        'old_purchase_order_item_id' => $item->po_item_check,
                    ]);
                }

                $migrated++;
            }

            DB::commit();
            return redirect()->back()->with('success', "$migrated PR(s) migrated, $skipped skipped (already existing).");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Migration failed: ' . $e->getMessage());
        }
    }

    public function purchase_order_migration()
    {
        abort_if(Gate::denies('purchase_order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('migration.purchase_order');
    }

    public function getMigratePurchaseOrders(Request $request)
    {            
        // $data = ProcsysPr::all()->sortByDesc('id');
        $data = DB::connection('procsys')->table('purchase_orders')->get();
    
        return datatables($data)->make(true);   

    }

    public function purchase_order_migration_execute()
    {
        DB::beginTransaction();

        try {
            $oldOrders = DB::connection('procsys')->table('purchase_orders')->get();

            $migrated = 0;
            $skipped = 0;

            foreach ($oldOrders as $oldOrder) {
                // Skip if already migrated
                $alreadyMigrated = DB::table('purchase_orders')
                    ->where('old_po_id', $oldOrder->id)
                    ->exists();

                if ($alreadyMigrated) {
                    $skipped++;
                    continue;
                }

                // Get corresponding new purchase_request_id using old_pr_id
                $newPr = DB::table('purchase_requests')
                    ->where('old_pr_id', $oldOrder->po_id)
                    ->first();

                $newPrId = $newPr?->id;

                $newOrderId = DB::table('purchase_orders')->insertGetId([
                    'po_no' => $oldOrder->po_no,
                    'date' => $oldOrder->po_date,
                    'delivery_place' => $oldOrder->delivery_place,
                    'delivery_date' => $oldOrder->delivery_date,
                    'delivery_term' => $oldOrder->delivery_term,
                    'payment_term' => $oldOrder->payment_term,
                    'mode' => $oldOrder->mode,
                    'status' => $oldOrder->status,
                    'remarks' => $oldOrder->remarks,
                    'created_at' => $oldOrder->created_at,
                    'updated_at' => $oldOrder->updated_at,
                    'supplier_id' => $oldOrder->supplier_id,
                    'purchase_request_id' => $newPrId,
                    'old_po_id' => $oldOrder->id,
                ]);

                $oldItems = DB::connection('procsys')->table('purchase_order_items')
                    ->where('po_id', $oldOrder->id)
                    ->get();

                foreach ($oldItems as $item) {
                    // Optional: match related PR item to link (if necessary)
                    $newPrItem = DB::table('purchase_request_items')
                        ->where('purchase_request_id', $newPrId)
                        ->where('description', 'like', '%' . $item->description . '%')
                        ->first();

                    $newPrItemId = $newPrItem?->id;

                    DB::table('purchase_order_items')->insert([
                        'purchase_order_id' => $newOrderId,
                        'stock_no' => $item->stock_no,
                        'description' => $item->description,
                        'quantity' => $item->quantity,
                        'unit' => $item->unit,
                        'unit_cost' => $item->unit_cost,
                        'amount' => $item->amount,
                        'status' => $item->status,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'purchase_request_item_id' => $newPrItemId, 
                        'old_purchase_order_item_id' => $item->id, 
                    ]);
                }

                $migrated++;
            }

            DB::commit();
            return redirect()->back()->with('success', "$migrated PO(s) migrated, $skipped skipped (already existing).");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Migration failed: ' . $e->getMessage());
        }
    }
    

    public function iar_migration()
    {
        abort_if(Gate::denies('iar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('migration.iar');
    }

    public function getMigrateIars(Request $request)
    { 
        // $data = DB::connection('procsys')->table('iars')->get();
        $data = DB::connection('procsys')->table('iars')
            ->join('purchase_requests', 'iars.pr_no', '=', 'purchase_requests.pr_no')
            ->select(
                'iars.*',
                'purchase_requests.pr_no',
                'purchase_requests.office',
                'purchase_requests.purpose'
            )
            ->get();
            
        return datatables($data)->make(true);   

    }

    public function iar_migration_execute()
    {
        DB::beginTransaction();

        try {
            $oldOrders = DB::connection('procsys')->table('iars')->get();

            $migrated = 0;
            $skipped = 0;

            foreach ($oldOrders as $oldOrder) {
                // Skip if already migrated
                $alreadyMigrated = DB::table('iars')
                    ->where('old_iar_id', $oldOrder->id)
                    ->exists();

                if ($alreadyMigrated) {
                    $skipped++;
                    continue;
                }

                $newPrData = DB::table('purchase_requests')
                    ->where('pr_no', 'like', '%' . $oldOrder->pr_no . '%')
                    ->first();

                $newPrId = null;
                if ($newPrData) {
                    $newPrId = $newPrData->id;
                }

                $newPoData = DB::table('purchase_orders')
                    ->where('po_no', 'like', '%' . $oldOrder->po_no . '%')
                    ->first();
                
                $newPoId = null;
                if ($newPoData) {
                    $newPoId = $newPoData->id;
                }

                $newSupplier = DB::table('suppliers')
                    ->where('name', 'like', '%' . $oldOrder->supplier . '%')
                    ->first();
               
                $newSupplierId = null;
                if ($newPoData) {
                    $newSupplierId = $newSupplier->id;
                }

                $newOrderId = DB::table('iars')->insertGetId([
                    'iar_no' => $oldOrder->iar_no,
                    'date' => $oldOrder->iar_date,
                    'invoice_no' => $oldOrder->invoice_no,
                    'invoice_date' => $oldOrder->invoice_date,
                    'status' => $oldOrder->status,
                    'type' => $oldOrder->type,
                    'nod_date' => $oldOrder->nod_date,
                    'nod_time' => $oldOrder->nod_time,
                    'created_at' => $oldOrder->created_at,
                    'updated_at' => $oldOrder->updated_at,
                    'purchase_order_id' => $newPoId,
                    'purchase_request_id' => $newPrId,
                    'supplier_id' => $newSupplierId,
                    'old_iar_id' => $oldOrder->id,
                ]);

                $oldItems = DB::connection('procsys')->table('stocks')
                    ->where('iar_no', $oldOrder->iar_no)
                    ->get();

                foreach ($oldItems as $item) {
                    
                    $newPoItem = DB::table('purchase_order_items')
                        ->where('purchase_order_id', $newPoId)
                        ->where('description', 'like', '%' . $item->description . '%')
                        ->first();

                    $newPoItemId = $newPoItem?->id;

                    $category = $item->category;

                    if ($item->category === 'Semi-Expendables') {
                        if ($item->unit_price < 5001) {
                            $category = 'LVSE'; // Low-Value Semi-Expendable
                        } else {
                            $category = 'HVSE'; // High-Value Semi-Expendable
                        }
                    }

                    DB::table('iar_items')->insert([
                        'iar_id' => $newOrderId,
                        'stock_no' => $item->stock_no,
                        'description' => $item->description,
                        'quantity' => $item->receipt_quantity,
                        'unit' => $item->unit,
                        'type' => $item->type,
                        'category' => $category,
                        'status' => $item->status,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                        'purchase_order_item_id' => $newPoItemId, 
                        'old_iar_item_id' => $item->id, 
                    ]);
                }

                $migrated++;
            }

            DB::commit();
            return redirect()->back()->with('success', "$migrated PO(s) migrated, $skipped skipped (already existing).");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Migration failed: ' . $e->getMessage());
        }
    }
}
