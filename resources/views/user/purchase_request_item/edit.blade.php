@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.purchase_request_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("user.purchase_request_item.update", [$purchaseRequestItem->id]) }}" enctype="multipart/form-data" id="edit_form" >
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.purchase_request_item.fields.description') }}</label>
                <textarea rows="6" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description', $purchaseRequestItem->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.description_helper') }}</span>
            </div>  
            <div class="form-group" style="margin-top: 30px">
                <label class="required" for="stock_no">{{ trans('cruds.purchase_request_item.fields.stock_no') }}</label>
                <input class="form-control {{ $errors->has('stock_no') ? 'is-invalid' : '' }}" type="text" name="stock_no" id="stock_no" value="{{ old('stock_no', $purchaseRequestItem->stock_no) }}" required>
                @if($errors->has('stock_no'))
                    <span class="text-danger">{{ $errors->first('stock_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.stock_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.purchase_request_item.fields.unit') }}</label>
                <select class="unit form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit" id="unit" required>
                    <option value disabled {{ old('unit', $purchaseRequestItem->unit) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->unit }}" {{ old('unit', $purchaseRequestItem->unit) == $unit->unit ? 'selected' : '' }}>
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
                <label class="required" for="quantity">{{ trans('cruds.purchase_request_item.fields.quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', $purchaseRequestItem->quantity) }}" required>
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.quantity_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="unit_price">{{ trans('cruds.purchase_request_item.fields.unit_price') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_price') ? 'is-invalid' : '' }}" type="text" name="unit_price" id="unit_price" value="{{ old('unit_price', $purchaseRequestItem->unit_price) }}" required>
                @if($errors->has('unit_price'))
                    <span class="text-danger">{{ $errors->first('unit_price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request_item.fields.unit_price_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="total_cost">{{ trans('cruds.purchase_request_item.fields.total_cost') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('budget') ? 'is-invalid' : '' }}" type="text" name="total_cost" id="total_cost" value="{{ old('total_cost', $purchaseRequestItem->total_cost) }}" readonly required>
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
            this.value = this.value.replace(/[^0-9\.]/g,'');
        }); 

        //automatically compute the modal estimated budget input       
        $("input").change(function(){
            var total_cost = 0; 
            var quantity = parseFloat($("input[name=quantity]").val());
            var cost = parseFloat($("input[name=unit_price]").val());           
            $("input[name=quantity], input[name=unit_price]").each(function(){                   
                total_cost = quantity * cost; 
                total_cost = total_cost.toFixed(2);              
            })
            if(!isNaN(parseInt(total_cost)))
                $("input[name=total_cost]").val(total_cost);
            else
                $("input[name=total_cost]").val('');
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
                $('#errmessage').text("*Quantity must not exceed the Available Quantity.");
            } else {
                $('#errmessage').text(""); // Clear error message if any
                // Allow form submission by not calling preventDefault
                this.submit();
            }          
        }); 
        
    }); 

</script>

@endsection