@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.purchase_request_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("user.purchase_request_item.store") }}" enctype="multipart/form-data" id="create_form" >
            @csrf
            <input type="text" name="purchase_request_id" id="purchase_request_id" value="{{ $id }}" hidden>    
            <input type="text" name="ppmp_item_id" id="ppmp_item_id" hidden>    
            <div class="form-group row add">
                <label class="required" for="search">Search Item</label> 
                <div class="position-relative w-100 p-2">
                    <input type="text" class="select_description form-control pl-4" 
                        id="select_description" list="pr_item" name="select_description" 
                        onfocus="this.value=''" onchange="this.blur();" autocomplete="off" 
                        style="font-size:12px;">

                    <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #888;"></i>
                        <datalist id="pr_item" name="pr_item" >                              
                            @foreach($items as $item)
                                <option data-value="{{$item->description}}|{{$item->code}}|{{$item->unit}}|{{$item->cost}}|{{$item->balance}}|{{$item->id}}" value="{{$item->description}}">
                            @endforeach                                
                        </datalist>  
                </div>            
            </div>      
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.purchase_request_item.fields.description') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}" required></textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.description_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="stock_no">{{ trans('cruds.purchase_request_item.fields.stock_no') }}</label>
                <input class="form-control {{ $errors->has('stock_no') ? 'is-invalid' : '' }}" type="text" name="stock_no" id="stock_no" value="{{ old('stock_no', '') }}" required>
                @if($errors->has('stock_no'))
                    <span class="text-danger">{{ $errors->first('stock_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.stock_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.purchase_request_item.fields.unit') }}</label>
                <select class="unit form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit" id="unit" required>
                    <option value disabled {{ old('unit', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->unit }}" {{ old('unit') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->unit }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="available_quantity">{{ trans('cruds.purchase_request_item.fields.available_quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('available_quantity') ? 'is-invalid' : '' }}" type="text" name="available_quantity" id="available_quantity" value="{{ old('available_quantity', '') }}" readonly required>
                @if($errors->has('available_quantity'))
                    <span class="text-danger">{{ $errors->first('available_quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.available_quantity_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.purchase_request_item.fields.quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', '') }}" required>
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.quantity_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="unit_price">{{ trans('cruds.purchase_request_item.fields.unit_price') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_price') ? 'is-invalid' : '' }}" type="text" name="unit_price" id="unit_price" value="{{ old('unit_price', '') }}" required>
                @if($errors->has('unit_price'))
                    <span class="text-danger">{{ $errors->first('unit_price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.unit_price_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="total_cost">{{ trans('cruds.purchase_request_item.fields.total_cost') }}</label>
                <input class="form-control {{ $errors->has('total_cost') ? 'is-invalid' : '' }}" type="text" name="total_cost" id="total_cost" value="{{ old('total_cost', '') }}" readonly required>
                @if($errors->has('total_cost'))
                    <span class="text-danger">{{ $errors->first('total_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.total_cost_helper') }}</span>
            </div> 
            <div class="form-group"> 
                <label for="errmessage" class="errmessage control-label" id="errmessage" name="errmessage" style="color:red"></label>
                <div>
                    <input type="message" class="message form-control" id="message" name="message" hidden>
                </div>
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
            $("input[name=unit_price]").val(parts[3]);
            $("input[name=available_quantity]").val(parts[4]);
            $("input[name=ppmp_item_id]").val(parts[5]);

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
        $("input[name=quantity], input[name=unit_price]").change(function(){
            var total_cost = 0; 
            var quantity = parseFloat($("input[name=quantity]").val());
            var costInput = $("input[name=unit_price]").val().replace(/,/g, '');
            var cost = parseFloat(costInput); 

            // Calculate the budget only if both quantity and cost are valid numbers
            if (!isNaN(quantity) && !isNaN(cost)) {
                total_cost = quantity * cost; 
                // Keep the budget as a number, but prepare for display with fixed decimal places
                total_cost = total_cost.toFixed(2);              
            }

            // Update the budget input field, converting it to a string formatted for display
            if (!isNaN(parseFloat(total_cost))) {
                $("input[name=total_cost]").val(total_cost); // Set the budget directly
            } else {
                $("input[name=total_cost]").val('');
            }
        });

        //automatically compare the available quantity and requested quantity
        $("input").change(function(){
            var comquantity = 0;
            var available_quantity = parseFloat($("input[name=available_quantity]").val());
            var quantity = parseFloat($("input[name=quantity]").val());
                         
            $("input[name=available_quantity], input[name=quantity]").each(function(){
                comquantity = available_quantity - quantity; 
            })            
            $("input[name=message]").val(comquantity);            
        });

        $("#create_form").submit(function(e) {
            e.preventDefault();  
            var comquantity = $('#message').val();
            if(comquantity < 0){
                $('#errmessage').text("*Requested Quantity must not exceed the Available Quantity.");
            } else {
                $('#errmessage').text(""); // Clear error message if any
                // Allow form submission by not calling preventDefault
                this.submit();
            }          
        }); 
       
    }); 

</script>

@endsection
