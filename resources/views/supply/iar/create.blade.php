@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.iar.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.iar.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="supplier_id" id="supplier_id" hidden>
            <div class="form-group">
                <label class="required" for="purchase_order_id">{{ trans('cruds.purchase_order.fields.po_no') }}</label>
                <select class="form-control {{ $errors->has('purchase_order_id') ? 'is-invalid' : '' }}" name="purchase_order_id" id="purchase_order_id" required>
                    <option value="" disabled {{ old('purchase_order_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($purchaseOrders as $purchaseOrder)
                        <option value="{{ $purchaseOrder->id }}" 
                            data-supplier_id="{{ $purchaseOrder->supplier_id }}" 
                            {{ old('purchase_order_id') == $purchaseOrder->id ? 'selected' : '' }}>
                            {{ $purchaseOrder->po_no }} - {{ $purchaseOrder->supplier->name }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('purchase_order_id'))
                    <span class="text-danger">{{ $errors->first('purchase_order_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.po_no_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.iar.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', '') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.date_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="invoice_no">{{ trans('cruds.iar.fields.invoice_no') }}</label>
                <input class="form-control {{ $errors->has('invoice_no') ? 'is-invalid' : '' }}" type="text" name="invoice_no" id="invoice_no" value="{{ old('invoice_no', '') }}" required>
                @if($errors->has('invoice_no'))
                    <span class="text-danger">{{ $errors->first('invoice_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.invoice_no_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="invoice_date">{{ trans('cruds.iar.fields.invoice_date') }}</label>
                <input class="form-control date {{ $errors->has('invoice_date') ? 'is-invalid' : '' }}" type="text" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', '') }}" required>
                @if($errors->has('invoice_date'))
                    <span class="text-danger">{{ $errors->first('invoice_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.invoice_date_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.iar.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', '') }}" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Iar::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.type_helper') }}</span>
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
        const fundIdField = document.getElementById('supplier_id');

        fundSourceDropdown.addEventListener('change', function () {
            const selectedOption = fundSourceDropdown.options[fundSourceDropdown.selectedIndex];
            const supplier_id = selectedOption.getAttribute('data-supplier_id');

            // Set the amount field's value
            fundIdField.value = supplier_id || ''; // Default to empty if no amount is provided
        });
    });
</script>

@endsection