@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.iirusp_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.iirusp_item.update", [$iiruspItem->id]) }}" enctype="multipart/form-data" id="edit_form" >
            @method('PUT')
            @csrf   
            <input type="text" name="id" id="id" value="{{ $iiruspItem->id }}" hidden>      
            <div class="form-group">
                <label class="required" for="date_acquired">{{ trans('cruds.iirup_item.fields.date_acquired') }}</label>
                <input class="form-control {{ $errors->has('date_acquired') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="date_acquired" id="date_acquired" value="{{ old('date_acquired', $iiruspItem->date_acquired) }}" required>
                @if($errors->has('date_acquired'))
                    <span class="text-danger">{{ $errors->first('date_acquired') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.date_acquired_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="particulars">{{ trans('cruds.iirup_item.fields.particulars') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('particulars') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="particulars" id="particulars" required>{{ old('particulars', $iiruspItem->particulars) }}</textarea>
                @if($errors->has('particulars'))
                    <span class="text-danger">{{ $errors->first('particulars') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.particulars_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="" for="semi_expendable_property_no">{{ trans('cruds.iirup_item.fields.semi_expendable_property_no') }}</label>
                <input class="form-control {{ $errors->has('semi_expendable_property_no') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="semi_expendable_property_no" id="semi_expendable_property_no" value="{{ old('semi_expendable_property_no', $iiruspItem->semi_expendable_property_no) }}" >
                @if($errors->has('semi_expendable_property_no'))
                    <span class="text-danger">{{ $errors->first('semi_expendable_property_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.semi_expendable_property_no_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.iirup_item.fields.quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', $iiruspItem->quantity) }}" required>
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.quantity_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="unit_cost">{{ trans('cruds.iirup_item.fields.unit_cost') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_cost') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="unit_cost" id="unit_cost" value="{{ old('unit_cost', $iiruspItem->unit_cost) }}" required>
                @if($errors->has('unit_cost'))
                    <span class="text-danger">{{ $errors->first('unit_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.unit_cost_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="total_cost">{{ trans('cruds.iirup_item.fields.total_cost') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('total_cost') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="total_cost" id="total_cost" value="{{ old('total_cost', $iiruspItem->total_cost) }}" readonly required>
                @if($errors->has('total_cost'))
                    <span class="text-danger">{{ $errors->first('total_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.total_cost_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="depreciation">{{ trans('cruds.iirup_item.fields.depreciation') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('depreciation') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="depreciation" id="depreciation" value="{{ old('depreciation', $iiruspItem->depreciation) }}" >
                @if($errors->has('depreciation'))
                    <span class="text-danger">{{ $errors->first('depreciation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.depreciation_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="losses">{{ trans('cruds.iirup_item.fields.losses') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('losses') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="losses" id="losses" value="{{ old('losses', $iiruspItem->losses) }}" >
                @if($errors->has('losses'))
                    <span class="text-danger">{{ $errors->first('losses') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.losses_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="carrying_amount">{{ trans('cruds.iirup_item.fields.carrying_amount') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('carrying_amount') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="carrying_amount" id="carrying_amount" value="{{ old('carrying_amount', $iiruspItem->carrying_amount) }}" >
                @if($errors->has('carrying_amount'))
                    <span class="text-danger">{{ $errors->first('carrying_amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.carrying_amount_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="remarks">{{ trans('cruds.iirup_item.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', $iiruspItem->remarks) }}" >
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.remarks_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="sale">{{ trans('cruds.iirup_item.fields.sale') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('sale') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="sale" id="sale" value="{{ old('sale', $iiruspItem->sale) }}" >
                @if($errors->has('sale'))
                    <span class="text-danger">{{ $errors->first('sale') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.sale_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="" for="transfer">{{ trans('cruds.iirup_item.fields.transfer') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('transfer') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="transfer" id="transfer" value="{{ old('transfer', $iiruspItem->transfer) }}" >
                @if($errors->has('transfer'))
                    <span class="text-danger">{{ $errors->first('transfer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.transfer_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="" for="destruction">{{ trans('cruds.iirup_item.fields.destruction') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('destruction') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="destruction" id="destruction" value="{{ old('destruction', $iiruspItem->destruction) }}" >
                @if($errors->has('destruction'))
                    <span class="text-danger">{{ $errors->first('destruction') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.destruction_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="" for="others">{{ trans('cruds.iirup_item.fields.others') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('others') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="others" id="others" value="{{ old('others', $iiruspItem->others) }}" >
                @if($errors->has('others'))
                    <span class="text-danger">{{ $errors->first('others') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.others_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="" for="total_dispose">{{ trans('cruds.iirup_item.fields.total_dispose') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('total_dispose') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="total_dispose" id="total_dispose" value="{{ old('total_dispose', $iiruspItem->total_dispose) }}" >
                @if($errors->has('total_dispose'))
                    <span class="text-danger">{{ $errors->first('total_dispose') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.total_dispose_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="or_no">{{ trans('cruds.iirup_item.fields.or_no') }}</label>
                <input class="form-control {{ $errors->has('or_no') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="or_no" id="or_no" value="{{ old('or_no', $iiruspItem->or_no) }}" >
                @if($errors->has('or_no'))
                    <span class="text-danger">{{ $errors->first('or_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.or_no_helper') }}</span>
            </div>       
            <div class="form-group">
                <label class="" for="amount">{{ trans('cruds.iirup_item.fields.amount') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('amount') ? 'is-invalid' : $iiruspItem->id }}" type="text" name="amount" id="amount" value="{{ old('amount', $iiruspItem->amount) }}" >
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.amount_helper') }}</span>
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

    // Automatically compute the modal total_cost input       
    $("input[name=quantity], input[name=unit_cost]").change(function(){
        var budget = 0; 
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
            $("input[name=total_cost]").val(amount); // Set the budget directly
        } else {
            $("input[name=total_cost]").val('');
        }
    });

</script>

@endsection