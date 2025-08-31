<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\IcsHv;
use App\Models\IcsItemHv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class SpHvIssuedController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('recipient_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $id = Auth::user()->employee_id;
        $role = Auth::user()->hasRole('Admin');

        return view('user.semi_expendable_hv_recipient.index', compact('id', 'role'));
    }

    public function getSpHvIssuedItems(Request $request)
    {
        $role = $request->role;
        $employee_id = $request->id;

        if($role == 1){
            $ics_items = IcsItemHv::with('ics_hv')->get();
        } else {
            $ics_items = IcsItemHv::with('ics_hv')
                ->whereHas('ics_hv', function ($query) use ($employee_id) {
                    $query->where('employee_id', $employee_id);
                })
                ->get();
        }

        $data = $ics_items->map(function ($item) {
            return [
                'id' => $item->id,
                'date' => $item->ics_hv->date,
                'ics_hv_no' => $item->ics_hv->ics_hv_no,
                'quantity' => $item->quantity,
                'unit' => $item->unit,
                'unit_cost' => $item->unit_cost,
                'total_cost' => $item->total_cost,
                'description' => $item->description,
                'inventory_item_no' => $item->inventory_item_no,
                'lifespan' => $item->lifespan,
                'serial_no' => $item->serial_no,
                'type' => $item->type,
                'remarks' => $item->remarks
            ];
        });

        return datatables($data)->make(true);
    }
    
}
