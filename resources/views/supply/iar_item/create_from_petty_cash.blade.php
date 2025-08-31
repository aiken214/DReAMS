@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.iar_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.iar_item.store_from_petty_cash") }}" enctype="multipart/form-data" id="create_form" >
            @csrf
            <input type="text" name="iar_id" id="iar_id" value="{{ $id }}" hidden> 
            <div class="form-group">
                <label class="required" for="purchase_request_item_id">{{ trans('cruds.iar_item.fields.search_item') }}</label>
                <select class="form-control {{ $errors->has('purchase_request_item_id') ? 'is-invalid' : '' }}" name="purchase_request_item_id" id="purchase_request_item_id" required>
                    <option value="" disabled {{ old('purchase_request_item_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($purchaseRequestItems as $purchaseRequestItem)
                        <option value="{{ $purchaseRequestItem->id }}" 
                            data-description="{{ $purchaseRequestItem->description }}" 
                            data-stock_no="{{ $purchaseRequestItem->stock_no }}" 
                            data-unit="{{ $purchaseRequestItem->unit }}" 
                            data-unit_price="{{ $purchaseRequestItem->unit_price }}" 
                            data-po_quantity="{{ $purchaseRequestItem->quantity }}" 
                            {{ old('purchase_request_item_id') == $purchaseRequestItem->id ? 'selected' : '' }}>
                            {{ $purchaseRequestItem->description }} 
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('purchase_request_item_id'))
                    <span class="text-danger">{{ $errors->first('purchase_request_item_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar_item.fields.search_item_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description" hidden>{{ trans('cruds.iar_item.fields.description') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}" hidden readonly required></textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar_item.fields.description_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="stock_no">{{ trans('cruds.iar_item.fields.stock_no') }}</label>
                <input class="form-control {{ $errors->has('stock_no') ? 'is-invalid' : '' }}" type="text" name="stock_no" id="stock_no" value="{{ old('stock_no', '') }}" readonly required>
                @if($errors->has('stock_no'))
                    <span class="text-danger">{{ $errors->first('stock_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar_item.fields.stock_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.iar_item.fields.unit') }}</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', '') }}" readonly required>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar_item.fields.unit_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="unit_price">{{ trans('cruds.iar_item.fields.unit_price') }}</label>
                <input class="form-control {{ $errors->has('unit_price') ? 'is-invalid' : '' }}" type="text" name="unit_price" id="unit_price" value="{{ old('unit_price', '') }}" readonly required>
                @if($errors->has('unit_price'))
                    <span class="text-danger">{{ $errors->first('unit_price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar_item.fields.unit_price_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="po_quantity">{{ trans('cruds.iar_item.fields.po_quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('po_quantity') ? 'is-invalid' : '' }}" type="text" name="po_quantity" id="po_quantity" value="{{ old('po_quantity', '') }}" readonly required>
                @if($errors->has('po_quantity'))
                    <span class="text-danger">{{ $errors->first('po_quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar_item.fields.po_quantity_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.iar_item.fields.quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_cost') ? 'is-invalid' : '' }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', '') }}" required>
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar_item.fields.quantity_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.iar_item.fields.type') }}</label>
                <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', '') }}" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\IarItem::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar_item.fields.type_helper') }}</span>
            </div>      
            <div class="form-group">
                <label class="required" for="category">{{ trans('cruds.iar_item.fields.category') }}</label>
                <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" name="category" id="category" value="{{ old('category', '') }}" required>
                    <option value disabled {{ old('category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\IarItem::CATEGORY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('category', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar_item.fields.category_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="status">{{ trans('cruds.iar_item.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', '') }}" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\IarItem::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar_item.fields.status_helper') }}</span>
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
    document.addEventListener('DOMContentLoaded', function () {
        const purchase_request_item_idDropdown = document.getElementById('purchase_request_item_id');
        const descriptionField = document.getElementById('description');
        const stock_noField = document.getElementById('stock_no');
        const unitField = document.getElementById('unit');
        const unit_priceField = document.getElementById('unit_price');
        const po_quantityField = document.getElementById('po_quantity');

        purchase_request_item_idDropdown.addEventListener('change', function () {
            const selectedOption = purchase_request_item_idDropdown.options[purchase_request_item_idDropdown.selectedIndex];
            const description = selectedOption.getAttribute('data-description');
            const stock_no = selectedOption.getAttribute('data-stock_no');
            const unit = selectedOption.getAttribute('data-unit');
            const unit_price = selectedOption.getAttribute('data-unit_price');
            const po_quantity = selectedOption.getAttribute('data-po_quantity');

            // Set the field's value
            descriptionField.value = description || '';
            stock_noField.value = stock_no || '';
            unitField.value = unit || '';
            unit_priceField.value = unit_price || '';
            po_quantityField.value = po_quantity || '';
        });
    });

    //accept number only
    $('.numbers').keyup(function () { 
            this.value = this.value.replace(/[^0-9\.]/g,'');
        });  

    //automatically compare the available quantity and requested quantity
    $("input").change(function(){
        var comquantity = 0;
        var po_quantity = parseFloat($("input[name=po_quantity]").val());
        var quantity = parseFloat($("input[name=quantity]").val());
                        
        $("input[name=po_quantity], input[name=quantity]").each(function(){
            comquantity = po_quantity - quantity; 
        })            
        $("input[name=message]").val(comquantity);            
    });

    $("#create_form").submit(function(e) {
        e.preventDefault();  
        var comquantity = $('#message').val();
        if(comquantity < 0){
            $('#errmessage').text("*Received Quantity must not exceed the PO Quantity.");
        } else {
            $('#errmessage').text(""); // Clear error message if any
            // Allow form submission by not calling preventDefault
            this.submit();
        }          
    }); 
</script>

@endsection