<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\IcsLv;
use App\Models\IcsItemLv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class SpLvIssuedController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('recipient_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $id = Auth::user()->employee_id;
        $role = Auth::user()->hasRole('Admin');

        return view('user.semi_expendable_lv_recipient.index', compact('id', 'role'));
    }

    public function getSpLvIssuedItems(Request $request)
    {
        $role = $request->role;
        $employee_id = $request->id;

        if($role == 1){
            $ics_items = IcsItemLv::with('ics_lv')->get();
        } else {
            $ics_items = IcsItemLv::with('ics_lv')
                ->whereHas('ics_lv', function ($query) use ($employee_id) {
                    $query->where('employee_id', $employee_id);
                })
                ->get();
        }

        $data = $ics_items->map(function ($item) {
            return [
                'id' => $item->id,
                'date' => $item->ics_lv->date,
                'ics_lv_no' => $item->ics_lv->ics_lv_no,
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
