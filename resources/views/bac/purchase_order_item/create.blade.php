@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.purchase_order_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("bac.purchase_order_item.store") }}" enctype="multipart/form-data" id="create_form" >
            @csrf
            <input type="text" name="purchase_order_id" id="purchase_order_id" value="{{ $id }}" hidden>    
            <input type="text" name="purchase_request_item_id" id="purchase_request_item_id" hidden>    
            <div class="form-group row add">
                <label class="required" for="search">Select Item</label> 
                <div class="position-relative w-100 p-2">
                    <input type="text" class="select_description form-control pl-4" 
                        id="select_description" list="pr_item" name="select_description" 
                        onfocus="this.value=''" onchange="this.blur();" autocomplete="off" 
                        style="font-size:12px;">

                    <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #888;"></i>
                        <datalist id="pr_item" name="pr_item" >                              
                            @foreach($items as $item)
                                <option data-value="{{$item->description}}|{{$item->stock_no}}|{{$item->unit}}|{{$item->quantity}}|{{$item->id}}" value="{{$item->description}}">
                            @endforeach                                
                        </datalist>  
                </div>            
            </div>      
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.purchase_order_item.fields.description') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}" readonly required></textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.description_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="stock_no">{{ trans('cruds.purchase_order_item.fields.stock_no') }}</label>
                <input class="form-control {{ $errors->has('stock_no') ? 'is-invalid' : '' }}" type="text" name="stock_no" id="stock_no" value="{{ old('stock_no', '') }}" readonly required>
                @if($errors->has('stock_no'))
                    <span class="text-danger">{{ $errors->first('stock_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.stock_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.purchase_order_item.fields.unit') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', '') }}" readonly required>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.unit_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.purchase_order_item.fields.quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', '') }}" readonly required>
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.quantity_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="unit_cost">{{ trans('cruds.purchase_order_item.fields.unit_cost') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_cost') ? 'is-invalid' : '' }}" type="text" name="unit_cost" id="unit_cost" value="{{ old('unit_cost', '') }}" required>
                @if($errors->has('unit_cost'))
                    <span class="text-danger">{{ $errors->first('unit_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.unit_cost_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.purchase_order_item.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', '') }}" readonly required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
                <a class="btn btn-default" href="{{ URL::previous() }}">
                    {{ trans('global.cancel') }}
                </a>
            </div>  
        </form>
    </div>
</div>
@endsection

@section('scripts')

<script>

    $(document).ready( function () {
        //accept number only
        $('.numbers').keyup(function () { 
            this.value = this.value.replace(/[^0-9.,]/g, '');
        });   
                
        // autofill with items data
        $("#select_description").change(function(){
            var shownVal = document.getElementById("select_description").value;
            var value2send = document.querySelector("#pr_item option[value='" + shownVal + "']").dataset.value;
            
            // Split the data from the selected option
            var parts = value2send.split('|');
            
            // Update the fields with the selected item's data
            $("textarea[name=description]").val(parts[0]);
            $("input[name=stock_no]").val(parts[1]);
            $("input[name=unit]").val(parts[2]);
            $("input[name=quantity]").val(parts[3]);
            $("input[name=purchase_request_item_id]").val(parts[4]);

           // Find the correct `unit` option by text and set it as selected
            $("select[name=unit]").find("option").each(function() {
                if ($(this).text().trim() === parts[2].trim()) {
                    $(this).prop("selected", true);
                } else {
                    $(this).prop("selected", false);
                }
            });
        });
        
        // Automatically compute the modal estimated budget input       
        $("input[name=quantity], input[name=unit_cost]").change(function(){
            var amount = 0; 
            var quantity = parseFloat($("input[name=quantity]").val());
            var costInput = $("input[name=unit_cost]").val().replace(/,/g, '');
            var cost = parseFloat(costInput); 

            // Calculate the budget only if both quantity and cost are valid numbers
            if (!isNaN(quantity) && !isNaN(cost)) {
                amount = quantity * cost; 
                // Keep the budget as a number, but prepare for display with fixed decimal places
                amount = amount.toFixed(2);              
            }

            // Update the budget input field, converting it to a string formatted for display
            if (!isNaN(parseFloat(amount))) {
                $("input[name=amount]").val(amount); // Set the budget directly
            } else {
                $("input[name=amount]").val('');
            }
        });
       
    }); 

</script>

@endsection
