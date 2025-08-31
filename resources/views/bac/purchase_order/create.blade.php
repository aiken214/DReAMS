@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.purchase_order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("bac.purchase_order.store") }}" enctype="multipart/form-data">
            @csrf         
            <div class="form-group">
                <label class="required" for="purchase_request_id">{{ trans('cruds.purchase_order.fields.pr_no') }}</label>
                <select class="form-control {{ $errors->has('purchase_request_id') ? 'is-invalid' : '' }}" name="purchase_request_id" id="purchase_request_id" required>
                    <option value disabled {{ old('purchase_request_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($purchaseRequests as $purchaseRequest)
                        <option value="{{ $purchaseRequest->id }}" {{ old('purchase_request_id') == $purchaseRequest->id ? 'selected' : '' }}>
                            {{ $purchaseRequest->pr_no }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('purchase_request_id'))
                    <span class="text-danger">{{ $errors->first('purchase_request_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.pr_no_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.purchase_order.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', '') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.date_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="supplier_id">{{ trans('cruds.purchase_order.fields.supplier') }}</label>
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
                <span class="help-block">{{ trans('cruds.purchase_order.fields.supplier_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="mode">{{ trans('cruds.purchase_order.fields.mode') }}</label>
                <select class="form-control {{ $errors->has('mode') ? 'is-invalid' : '' }}" type="text" name="mode" id="mode" value="{{ old('mode', '') }}" required>
                    <option value disabled {{ old('mode', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\PurchaseOrder::MODE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('mode', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('mode'))
                    <span class="text-danger">{{ $errors->first('mode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.mode_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="delivery_place">{{ trans('cruds.purchase_order.fields.delivery_place') }}</label>
                <input class="form-control {{ $errors->has('delivery_place') ? 'is-invalid' : '' }}" type="text" name="delivery_place" id="delivery_place" value="{{ old('delivery_place', '') }}" required>
                @if($errors->has('delivery_place'))
                    <span class="text-danger">{{ $errors->first('delivery_place') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.delivery_place_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="delivery_date">{{ trans('cruds.purchase_order.fields.delivery_date') }}</label>
                <input class="form-control date {{ $errors->has('delivery_date') ? 'is-invalid' : '' }}" type="text" name="delivery_date" id="delivery_date" value="{{ old('delivery_date', '') }}" required>
                @if($errors->has('delivery_date'))
                    <span class="text-danger">{{ $errors->first('delivery_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.delivery_date_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="delivery_term">{{ trans('cruds.purchase_order.fields.delivery_term') }} {{ '(No.of Days)'}}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('delivery_term') ? 'is-invalid' : '' }}" type="text" name="delivery_term" id="delivery_term" value="{{ old('delivery_term', '') }}" required>
                @if($errors->has('delivery_term'))
                    <span class="text-danger">{{ $errors->first('delivery_term') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.delivery_term_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="payment_term">{{ trans('cruds.purchase_order.fields.payment_term') }}</label>
                <input class="form-control {{ $errors->has('payment_term') ? 'is-invalid' : '' }}" type="text" name="payment_term" id="payment_term" value="{{ old('payment_term', '') }}" required>
                @if($errors->has('payment_term'))
                    <span class="text-danger">{{ $errors->first('payment_term') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.payment_term_helper') }}</span>
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

</script>

@endsection