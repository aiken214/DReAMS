@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.purchase_order_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("bac.purchase_order_item.update", [$purchaseOrderItem->id]) }}" enctype="multipart/form-data" id="edit_form" >
            @method('PUT')
            @csrf
            <input type="text" name="purchase_order_id" id="purchase_order_id" value="{{ $purchaseOrderItem->purchase_order_id }}" hidden>    
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.purchase_order_item.fields.description') }}</label>
                <textarea rows="6" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" readonly required> {{ old('description', $purchaseOrderItem->description) }} </textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.description_helper') }}</span>
            </div>  
            <div class="form-group" style="margin-top: 30px">
                <label class="required" for="stock_no">{{ trans('cruds.purchase_order_item.fields.stock_no') }}</label>
                <input class="form-control {{ $errors->has('stock_no') ? 'is-invalid' : '' }}" type="text" name="stock_no" id="stock_no" value="{{ old('stock_no', $purchaseOrderItem->stock_no) }}" readonly required>
                @if($errors->has('stock_no'))
                    <span class="text-danger">{{ $errors->first('stock_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.stock_no_helper') }}</span>
            </div>
            <div class="form-group" style="margin-top: 30px">
                <label class="required" for="unit">{{ trans('cruds.purchase_order_item.fields.unit') }}</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', $purchaseOrderItem->unit) }}" readonly required>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.purchase_order_item.fields.quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', $purchaseOrderItem->quantity) }}" readonly required>
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.quantity_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="unit_cost">{{ trans('cruds.purchase_order_item.fields.unit_cost') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_cost') ? 'is-invalid' : '' }}" type="text" name="unit_cost" id="unit_cost" value="{{ old('unit_cost', $purchaseOrderItem->unit_cost) }}" required>
                @if($errors->has('unit_cost'))
                    <span class="text-danger">{{ $errors->first('unit_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order_item.fields.unit_cost_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.purchase_order_item.fields.amount') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('budget') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', $purchaseOrderItem->amount) }}" readonly required>
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
            this.value = this.value.replace(/[^0-9\.]/g,'');
        }); 

        //automatically compute the modal estimated budget input       
        $("input").change(function(){
            var amount = 0; 
            var quantity = parseFloat($("input[name=quantity]").val());
            var cost = parseFloat($("input[name=unit_cost]").val());           
            $("input[name=quantity], input[name=unit_cost]").each(function(){                   
                amount = quantity * cost; 
                amount = amount.toFixed(2);              
            })
            if(!isNaN(parseInt(amount)))
                $("input[name=amount]").val(amount);
            else
                $("input[name=amount]").val('');
        });
        
    }); 

</script>

@endsection