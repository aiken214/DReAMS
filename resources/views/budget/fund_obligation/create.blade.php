@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.fund_obligation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("budget.fund_obligation.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="fund_id" id="fund_id" hidden>
            <div class="form-group">
                <label class="required" for="purchase_order_id">{{ trans('cruds.purchase_order.fields.po_no') }}</label>
                <select class="form-control {{ $errors->has('purchase_order_id') ? 'is-invalid' : '' }}" name="purchase_order_id" id="purchase_order_id" required>
                    <option value="" disabled {{ old('purchase_order_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($purchaseOrders as $purchaseOrder)
                        <option value="{{ $purchaseOrder->id }}" 
                            data-fund_id="{{ $purchaseOrder->purchase_request->fund_id }}" 
                            {{ old('purchase_order_id') == $purchaseOrder->id ? 'selected' : '' }}>
                            {{ $purchaseOrder->po_no }} - {{ $purchaseOrder->supplier->name }} - {{ number_format((float)$purchaseOrder->purchase_order_item_sum_amount, 2, '.', ',') }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('purchase_order_id'))
                    <span class="text-danger">{{ $errors->first('purchase_order_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.po_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.fund_obligation.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', '') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund_obligation.fields.date_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="obr_no">{{ trans('cruds.fund_obligation.fields.obr_no') }}</label>
                <input class="form-control {{ $errors->has('obr_no') ? 'is-invalid' : '' }}" type="text" name="obr_no" id="obr_no" value="{{ old('obr_no', '') }}" required>
                @if($errors->has('obr_no'))
                    <span class="text-danger">{{ $errors->first('obr_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund_obligation.fields.obr_no_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.fund_obligation.fields.amount') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', '') }}" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund_obligation.fields.amount_helper') }}</span>
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

    $(document).ready( function () {
        //accept number only
        $('.numbers').keyup(function () { 
            this.value = this.value.replace(/[^0-9\.]/g,'');
        });  

    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fundSourceDropdown = document.getElementById('purchase_order_id');
        const fundIdField = document.getElementById('fund_id');

        fundSourceDropdown.addEventListener('change', function () {
            const selectedOption = fundSourceDropdown.options[fundSourceDropdown.selectedIndex];
            const fund_id = selectedOption.getAttribute('data-fund_id');

            // Set the amount field's value
            fundIdField.value = fund_id || ''; // Default to empty if no amount is provided
        });
    });
</script>

@endsection

