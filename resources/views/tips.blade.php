<!-- 

---Display data in blade to check its content

<pre>{{ dd($data) }}</pre>

---(Updating only one data)
 
PurchaseOrder::where('id', $iar->purchase_order_id)->update(['status' => null]);

PurchaseOrderItem::where('id', $purchase_order_item_id)->update(['status' => $request->status]); 

---(Get the single value of id)

$station_id = Iirup::where('id', $id)->value('station_id');

---(Avoid null error)

{{ $rpcppe->parItem->par->date ?? '' }}

---(Limit the character display)

{{ Str::limit(optional($par->par_item->first())->description, 120) }}

---(Empty display if value is zero)

{{ $iiruspItem->total_cost != 0 ? number_format($iiruspItem->total_cost, 2, '.', ',') : '' }}
 
---(Load second relationship table (ex. iar->purchase_order->purchase_request))

$iar->load([
    'purchase_order.purchase_request:id,office', 
    'supplier:id,name,address,tin'
]);


---(Includes null value)

$purchaseOrderItems = PurchaseOrderItem::where('purchase_order_id', $purchase_order_id)
            ->where(function ($query) {
                $query->where('status', '!=', 'Complete')
                    ->orWhereNull('status'); // Include NULL status values
            })
            ->get();


---(To make the value is numeric)

        $quantity = is_numeric($request->quantity) ? (float) $request->quantity : 0;
        $unit_price = is_numeric(str_replace(',', '', $request->unit_price)) 
            ? (float) str_replace(',', '', $request->unit_price) 
            : 0;
        $amount = $quantity * $unit_price;


---Display value with comma and decimal place

    ->editColumn('total_cost', function($row) {
        // Remove commas from the total_cost value
        $totalCost = str_replace(',', '', $row->total_cost);
        // Check if the resulting value is numeric
        if (is_numeric($totalCost)) {
            // Convert to float and format with commas and two decimal places
            return number_format((float)$totalCost, 2, '.', ',');
        } else {
            // Handle cases where total_cost is not a valid number
            return 'N/A';
        }
    })
        
---(To fetch data 4 tables away, ris->iar->purchase_order->purchase_request)

    public function iar()
    {
        return $this->belongsTo(Iar::class, 'iar_id');
    }

    public function purchase_order()
    {
        return $this->hasOneThrough(
            PurchaseOrder::class, // Final destination model
            Iar::class,           // Intermediate model
            'id',                 // Foreign key on Iars (referencing Ris)
            'id',                 // Foreign key on PurchaseOrders (referencing Iars)
            'iar_id',             // Local key in Ris pointing to Iars
            'purchase_order_id'   // Local key in Iars pointing to PurchaseOrders
        );
    }

    public function purchase_request()
    {
        return $this->hasOneThrough(
            PurchaseRequest::class,  
            PurchaseOrder::class,    
            'id',                      // PK in PurchaseOrders
            'id',                      // PK in PurchaseRequests
            'purchase_order_id',        // FK in IARS (pointing to PurchaseOrders) ✅ Correct!
            'purchase_request_id'       // FK in PurchaseOrders (pointing to PurchaseRequests)
        );
    }

---Update with existing data display ang dropdown select. Example in supply.ris.edit view

    <div class="form-group">
        <label class="required" for="recipient">{{ trans('cruds.ris.fields.recipient') }}</label>
        <select class="unit form-control {{ $errors->has('recipient') ? 'is-invalid' : '' }}" name="recipient" id="recipient" required>
            
            <option value="{{ $ris->recipient }}" selected>
                {{ $ris->recipient }}
            </option>

            
            @foreach($employees as $employee)
                <option value="{{ $employee->fullname }}" {{ old('recipient') == $employee->fullname ? 'selected' : '' }}>
                    {{ $employee->fullname }}
                </option>
            @endforeach
        </select>
        @if($errors->has('recipient'))
            <span class="text-danger">{{ $errors->first('recipient') }}</span>
        @endif
        <span class="help-block">{{ trans('cruds.ris.fields.recipient_helper') }}</span>
    </div>  

---If data cannot be fetch and save, use $id

    public function edit(Ris $ris, $id)
    {
        abort_if(Gate::denies('ris_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 
        $ris = Ris::find($id); // Fetch RIS by ID

        if (!$ris) {
            abort(404, 'RIS not found'); // Return 404 if not found
        }

        $employees = DavnorsysEmployee::orderBy('fullname', 'asc')->get();
        $designations = Position::orderBy('position', 'asc')->get();
        $stations = Station::orderBy('station_name', 'asc')->get();

        return view('supply.ris.edit', compact('ris', 'employees', 'stations', 'designations'));
    }

    public function update(UpdateRisRequest $request, Ris $ris, $id)
    {
        $ris = Ris::findOrFail($id);
        $ris->update($request->all());

        return redirect()->route('supply.ris.index');
    }

---If no problem with the Route Binding, use this simple approach

    public function edit(Iar $iar)
    {
        abort_if(Gate::denies('iar_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $iar->load(['supplier:id,name']);

        return view('supply.iar.edit', compact('iar'));
    }

    public function update(UpdateIarRequest $request, Iar $iar)
    {
        $iar->update($request->all());

        return redirect()->route('supply.iar.index');
    }

---Edit blade with foreach

    <div class="form-group">
        <label class="required" for="accountable_officer">{{ trans('cruds.rpcppe.fields.accountable_officer') }}</label>
        <select class="accountable_officer form-control {{ $errors->has('accountable_officer') ? 'is-invalid' : '' }}" name="accountable_officer" id="accountable_officer" required>
        <option value="{{ $iirup->accountable_officer }}" selected>
                {{ $iirup->accountable_officer }}
            </option>
            @foreach($employees as $employee)
                <option value="{{ $employee->fullname }}" {{ old('accountable_officer') == $employee->fullname ? 'selected' : '' }}>
                    {{ $employee->fullname }}
                </option>
            @endforeach   
        </select>
        @if($errors->has('accountable_officer'))
            <span class="text-danger">{{ $errors->first('accountable_officer') }}</span>
        @endif
        <span class="help-block">{{ trans('cruds.rpcppe.fields.accountable_officer_helper') }}</span>
    </div>   

DATABASE 

---Deleting foriegn keys
    1. Delete foriegn keys (rpcppe_fk_6946269)
    2. Run in SQL "ALTER TABLE `property_cards` DROP FOREIGN KEY `rpcppe_fk_6946269`;"
    3. Delete column (rpcppe_id)

---If message "Nothin to migrate"
    1. Remove migration in the migrations table

-->




