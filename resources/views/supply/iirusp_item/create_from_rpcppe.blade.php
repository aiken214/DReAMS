@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.iirusp_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.iirusp_item.store_from_rpcsp") }}" enctype="multipart/form-data" id="create_form" >
            @csrf
            <input type="text" name="iirusp_id" id="iirusp_id" value="{{ $id }}" hidden>   
            <input type="text" name="particulars" id="particulars"  hidden> 
            <div class="form-group">
                <label class="required" for="rpcsp_id">{{ trans('cruds.iirup_item.fields.particulars') }}</label>
                <select class="form-control {{ $errors->has('rpcsp_id') ? 'is-invalid' : '' }}" name="rpcsp_id" id="rpcsp_id" required>
                    <option value="" disabled {{ old('rpcsp_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($rpcsps as $rpcsp)
                        <option value="{{ $rpcsp->id }}" 
                            data-date_acquired="{{ $rpcsp->ics_item_hv->ics_hv->date ?? '' }}" 
                            data-particulars="{{ $rpcsp->description }}" 
                            data-property_no="{{ $rpcsp->property_no }}" 
                            data-quantity="{{ $rpcsp->quantity_property_card }}" 
                            data-unit_cost="{{ $rpcsp->unit_value }}" 
                            {{ old('rpcsp_id') == $rpcsp->id ? 'selected' : '' }}>
                            {{ $rpcsp->ics_item_hv->ics_hv->recipient ?? '' }} - {{ $rpcsp->description }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('rpcsp_id'))
                    <span class="text-danger">{{ $errors->first('rpcsp_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.particulars_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_acquired">{{ trans('cruds.iirup_item.fields.date_acquired') }}</label>
                <input class="form-control {{ $errors->has('date_acquired') ? 'is-invalid' : '' }}" type="text" name="date_acquired" id="date_acquired" value="{{ old('date_acquired', '') }}" readonly required>
                @if($errors->has('date_acquired'))
                    <span class="text-danger">{{ $errors->first('date_acquired') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.date_acquired_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="" for="property_no">{{ trans('cruds.iirup_item.fields.property_no') }}</label>
                <input class="form-control {{ $errors->has('property_no') ? 'is-invalid' : '' }}" type="text" name="property_no" id="property_no" value="{{ old('property_no', '') }}" readonly>
                @if($errors->has('property_no'))
                    <span class="text-danger">{{ $errors->first('property_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.property_no_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.iirup_item.fields.quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', '') }}" readonly required>
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.quantity_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="unit_cost">{{ trans('cruds.iirup_item.fields.unit_cost') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_cost') ? 'is-invalid' : '' }}" type="text" name="unit_cost" id="unit_cost" value="{{ old('unit_cost', '') }}" readonly required>
                @if($errors->has('unit_cost'))
                    <span class="text-danger">{{ $errors->first('unit_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.unit_cost_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="total_cost">{{ trans('cruds.iirup_item.fields.total_cost') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('total_cost') ? 'is-invalid' : '' }}" type="text" name="total_cost" id="total_cost" value="{{ old('total_cost', '') }}" readonly required>
                @if($errors->has('total_cost'))
                    <span class="text-danger">{{ $errors->first('total_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.total_cost_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="depreciation">{{ trans('cruds.iirup_item.fields.depreciation') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('depreciation') ? 'is-invalid' : '' }}" type="text" name="depreciation" id="depreciation" value="{{ old('depreciation', '') }}" >
                @if($errors->has('depreciation'))
                    <span class="text-danger">{{ $errors->first('depreciation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.depreciation_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="losses">{{ trans('cruds.iirup_item.fields.losses') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('losses') ? 'is-invalid' : '' }}" type="text" name="losses" id="losses" value="{{ old('losses', '') }}" >
                @if($errors->has('losses'))
                    <span class="text-danger">{{ $errors->first('losses') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.losses_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="carrying_amount">{{ trans('cruds.iirup_item.fields.carrying_amount') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('carrying_amount') ? 'is-invalid' : '' }}" type="text" name="carrying_amount" id="carrying_amount" value="{{ old('carrying_amount', '') }}" >
                @if($errors->has('carrying_amount'))
                    <span class="text-danger">{{ $errors->first('carrying_amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.carrying_amount_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="remarks">{{ trans('cruds.iirup_item.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', '') }}" >
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.remarks_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="sale">{{ trans('cruds.iirup_item.fields.sale') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('sale') ? 'is-invalid' : '' }}" type="text" name="sale" id="sale" value="{{ old('sale', '') }}" >
                @if($errors->has('sale'))
                    <span class="text-danger">{{ $errors->first('sale') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.sale_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="" for="transfer">{{ trans('cruds.iirup_item.fields.transfer') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('transfer') ? 'is-invalid' : '' }}" type="text" name="transfer" id="transfer" value="{{ old('transfer', '') }}" >
                @if($errors->has('transfer'))
                    <span class="text-danger">{{ $errors->first('transfer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.transfer_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="" for="destruction">{{ trans('cruds.iirup_item.fields.destruction') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('destruction') ? 'is-invalid' : '' }}" type="text" name="destruction" id="destruction" value="{{ old('destruction', '') }}" >
                @if($errors->has('destruction'))
                    <span class="text-danger">{{ $errors->first('destruction') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.destruction_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="" for="others">{{ trans('cruds.iirup_item.fields.others') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('others') ? 'is-invalid' : '' }}" type="text" name="others" id="others" value="{{ old('others', '') }}" >
                @if($errors->has('others'))
                    <span class="text-danger">{{ $errors->first('others') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.others_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="" for="total_dispose">{{ trans('cruds.iirup_item.fields.total_dispose') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('total_dispose') ? 'is-invalid' : '' }}" type="text" name="total_dispose" id="total_dispose" value="{{ old('total_dispose', '') }}" >
                @if($errors->has('total_dispose'))
                    <span class="text-danger">{{ $errors->first('total_dispose') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.total_dispose_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="" for="or_no">{{ trans('cruds.iirup_item.fields.or_no') }}</label>
                <input class="form-control {{ $errors->has('or_no') ? 'is-invalid' : '' }}" type="text" name="or_no" id="or_no" value="{{ old('or_no', '') }}" >
                @if($errors->has('or_no'))
                    <span class="text-danger">{{ $errors->first('or_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup_item.fields.or_no_helper') }}</span>
            </div>       
            <div class="form-group">
                <label class="" for="amount">{{ trans('cruds.iirup_item.fields.amount') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', '') }}" >
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

    document.addEventListener('DOMContentLoaded', function () {
        const rpcppeIdDropdown = document.getElementById('rpcsp_id');
        const date_acquiredField = document.getElementById('date_acquired');
        const particularsField = document.getElementById('particulars');
        const property_noField = document.getElementById('property_no');
        const quantityField = document.getElementById('quantity');
        const unit_costField = document.getElementById('unit_cost');
        const total_costField = document.getElementById('total_cost'); // Add this line

        rpcppeIdDropdown.addEventListener('change', function () {
            const selectedOption = rpcppeIdDropdown.options[rpcppeIdDropdown.selectedIndex];
            const date_acquired = selectedOption.getAttribute('data-date_acquired');
            const particulars = selectedOption.getAttribute('data-particulars');
            const property_no = selectedOption.getAttribute('data-property_no');
            const quantity = selectedOption.getAttribute('data-quantity');
            const unit_cost = selectedOption.getAttribute('data-unit_cost');

            // Set the form fields
            date_acquiredField.value = date_acquired || ''; 
            particularsField.value = particulars || ''; 
            property_noField.value = property_no || ''; 
            quantityField.value = quantity || ''; 
            unit_costField.value = unit_cost || ''; 

            // Compute total cost
            const quantityFloat = parseFloat(quantity);
            const costFloat = parseFloat((unit_cost || '').replace(/,/g, ''));

            if (!isNaN(quantityFloat) && !isNaN(costFloat)) {
                const total = (quantityFloat * costFloat).toFixed(2);
                total_costField.value = total;
            } else {
                total_costField.value = '';
            }
        });
    });

    //accept number only
    $('.numbers').keyup(function () { 
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });  

    // Automatically compute the modal total_cost input       
    $("input[name=quantity], input[name=unit_cost]").on('input', function(){
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