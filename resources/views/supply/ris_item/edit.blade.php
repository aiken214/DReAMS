@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.ris_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.ris_item.update", [$risItem->id]) }}" enctype="multipart/form-data" id="edit_form" >
            @method('PUT')
            @csrf
            <input type="text" name="id" id="id" value="{{ $risItem->id }}" hidden> 
            <input type="text" name="ris_id" id="ris_id" value="{{ $risItem->ris_id }}" hidden> 
            <input type="text" name="stock_card_id" id="stock_card_id" value="{{ $risItem->stock_card_id }}" hidden> 
            <input type="text" name="semi_expendable_card_id" id="semi_expendable_card_id" value="{{ $risItem->semi_expendable_card_id }}" hidden> 
            <input type="text" name="property_card_id" id="property_card_id" value="{{ $risItem->property_card_id }}" hidden> 
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.ris_item.fields.description') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" readonly required>{{ old('description', $risItem->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris_item.fields.description_helper') }}</span>
            </div>               
            <div class="form-group">
                <label class="required" for="stock_no">{{ trans('cruds.ris_item.fields.stock_no') }}</label>
                <input class="form-control {{ $errors->has('stock_no') ? 'is-invalid' : '' }}" type="text" name="stock_no" id="stock_no" value="{{ old('stock_no', $risItem->stock_no) }}" readonly required>
                @if($errors->has('stock_no'))
                    <span class="text-danger">{{ $errors->first('stock_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris_item.fields.stock_no_helper') }}</span>
            </div>      
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.ris_item.fields.unit') }}</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', $risItem->unit) }}" readonly required>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris_item.fields.unit_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="category">{{ trans('cruds.ris_item.fields.category') }}</label>
                <input class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" name="category" id="category" value="{{ old('category', $risItem->category) }}" readonly required>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris_item.fields.category_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="balance_quantity">{{ trans('cruds.ris_item.fields.balance_quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('balance_quantity') ? 'is-invalid' : '' }}" type="text" name="balance_quantity" id="balance_quantity" value="{{ old('balance_quantity', $risItem->balance_quantity) }}" readonly required>
                @if($errors->has('balance_quantity'))
                    <span class="text-danger">{{ $errors->first('balance_quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris_item.fields.balance_quantity_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="issued_quantity">{{ trans('cruds.ris_item.fields.issued_quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('issued_quantity') ? 'is-invalid' : '' }}" type="text" name="issued_quantity" id="issued_quantity" value="{{ old('issued_quantity', $risItem->issued_quantity) }}" required>
                @if($errors->has('issued_quantity'))
                    <span class="text-danger">{{ $errors->first('issued_quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris_item.fields.issued_quantity_helper') }}</span>
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
@parent

<script>

    //accept number only
    $('.numbers').keyup(function () { 
            this.value = this.value.replace(/[^0-9\.]/g,'');
        });  

    //automatically compare the available quantity and requested quantity
    $("input").change(function(){
        var comquantity = 0;
        var balance_quantity = parseFloat($("input[name=balance_quantity]").val());
        var issued_quantity = parseFloat($("input[name=issued_quantity]").val());
                        
        $("input[name=balance_quantity], input[name=issued_quantity]").each(function(){
            comquantity = balance_quantity - issued_quantity; 
        })            
        $("input[name=message]").val(comquantity);            
    });

    $("#create_form").submit(function(e) {
        e.preventDefault();  
        var comquantity = $('#message').val();
        if(comquantity < 0){
            $('#errmessage').text("*Issued Quantity must not exceed the Balance Quantity.");
        } else {
            $('#errmessage').text(""); // Clear error message if any
            // Allow form submission by not calling preventDefault
            this.submit();
        }          
    }); 
</script>

@endsection