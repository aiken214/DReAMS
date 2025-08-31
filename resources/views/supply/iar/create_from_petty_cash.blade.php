@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.iar.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.iar.store_from_petty_cash") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="purchase_request_id">{{ trans('cruds.purchase_request.fields.pr_no') }}</label>
                <select class="form-control {{ $errors->has('purchase_request_id') ? 'is-invalid' : '' }}" name="purchase_request_id" id="purchase_request_id" required>
                    <option value="" disabled {{ old('purchase_request_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($purchaseRequests as $purchaseRequest)
                        <option value="{{ $purchaseRequest->id }}" 
                            {{ old('purchase_request_id') == $purchaseRequest->id ? 'selected' : '' }}>
                            {{ $purchaseRequest->pr_no }} - {{ $purchaseRequest->requested_by }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('purchase_request_id'))
                    <span class="text-danger">{{ $errors->first('purchase_request_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request.fields.pr_no_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="supplier_id">{{ trans('cruds.iar.fields.supplier') }}</label>
                <select class="form-control {{ $errors->has('supplier_id') ? 'is-invalid' : '' }}" name="supplier_id" id="supplier_id" required>
                    <option value disabled {{ old('supplier_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('supplier_id'))
                    <span class="text-danger">{{ $errors->first('supplier_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.supplier_helper') }}</span>
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

@endsection