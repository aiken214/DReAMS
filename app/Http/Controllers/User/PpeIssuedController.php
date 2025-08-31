<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Par;
use App\Models\ParItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class PpeIssuedController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('recipient_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        $id = Auth::user()->employee_id;
        $role = Auth::user()->hasRole('Admin');

        return view('user.property_recipient.index', compact('id', 'role'));
    }

    public function getPpeIssuedItems(Request $request)
    {              
        $role = $request->role;
        $employee_id = $request->id;

        if($role == 1){
            $par_items = ParItem::with('par')->get();
        } else {
            $par_items = ParItem::with('par')
                ->whereHas('par', function ($query) use ($employee_id) {
                    $query->where('employee_id', $employee_id);
                })
                ->get();
        }

        $data = $par_items->map(function ($item) { 
            return [
                'id' => $item->id,
                'date' => $item->par->date,
                'par_no' => $item->par->par_no,
                'quantity' => $item->quantity,
                'unit' => $item->unit,
                'amount' => $item->amount,
                'description' => $item->description,
                'property_no' => $item->property_no, 
                'date_acquired' => $item->date_acquired,
                'serial_no' => $item->serial_no,
                'type' => $item->type,
                'remarks' => $item->remarks
            ];
        });

        return datatables($data)->make(true);   
    }
}
