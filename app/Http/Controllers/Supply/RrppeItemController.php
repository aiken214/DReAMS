<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyParItemRequest;
use App\Http\Requests\StoreParItemRequest;
use App\Http\Requests\UpdateParItemRequest;
use App\Models\Rrppe;
use App\Models\Par;
use App\Models\ParItem;
use App\Models\RrppeItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class RrppeItemController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('rrppe_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
  
        $id = $request->id;
        
        return view('supply.rrppe_item.index', compact('id'));
    }

    public function getRrppeItem(Request $request)
    {     
        $id = $request->rrppe_id;   
        $rrppe = Rrppe::find($id);
     
        // Retrieve only data filtered by par_id
        $query = ParItem::where('par_id', $rrppe->par_id); 

        // Use DataTables query builder for better performance
        return datatables()->eloquent($query)->make(true); 
    }
    
    public function show(RrppeItem $rrppeItem)
    {
        abort_if(Gate::denies('rrppe_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rrppe = Rrppe::where('par_id', $rrppeItem->par_id)->first();

        // Add the rrppe_id if found
        if ($rrppe) {
            $rrppeItem->rrppe_id = $rrppe->id;
        }
        
        return view('supply.rrppe_item.show', compact('rrppeItem'));
    }  
}
