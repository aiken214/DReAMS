@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.purchase_order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("bac.purchase_order.update", [$purchaseOrder->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.purchase_order.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $purchaseOrder->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="supplier_id">{{ trans('cruds.purchase_order.fields.supplier') }}</label>
                <select class="form-control {{ $errors->has('supplier_id') ? 'is-invalid' : '' }}" name="supplier_id" id="supplier_id" required>
                    <option value disabled {{ old('supplier_id', $purchaseOrder->supplier_id) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchaseOrder->supplier_id) == $supplier->id ? 'selected' : '' }}>
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
                <label class="required" for="mode">{{ trans('cruds.ppmp_item.fields.mode') }}</label>
                <select class="form-control {{ $errors->has('mode') ? 'is-invalid' : '' }}" name="mode" id="mode" required>
                    <option value="" disabled {{ old('mode', $purchaseOrder->mode) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\PurchaseOrder::MODE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('mode', $purchaseOrder->mode) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('mode'))
                    <span class="text-danger">{{ $errors->first('mode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ppmp_item.fields.mode_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="delivery_place">{{ trans('cruds.purchase_order.fields.delivery_place') }}</label>
                <input class="form-control {{ $errors->has('delivery_place') ? 'is-invalid' : '' }}" type="text" name="delivery_place" id="delivery_place" value="{{ old('delivery_place', $purchaseOrder->delivery_place) }}" required>
                @if($errors->has('delivery_place'))
                    <span class="text-danger">{{ $errors->first('delivery_place') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.delivery_place_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="delivery_date">{{ trans('cruds.purchase_order.fields.delivery_date') }}</label>
                <input class="form-control date {{ $errors->has('delivery_date') ? 'is-invalid' : '' }}" type="text" name="delivery_date" id="delivery_date" value="{{ old('delivery_date', $purchaseOrder->delivery_date) }}" required>
                @if($errors->has('delivery_date'))
                    <span class="text-danger">{{ $errors->first('delivery_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.delivery_date_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="delivery_term">{{ trans('cruds.purchase_order.fields.delivery_term') }} {{ '(No.of Days)'}}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('delivery_term') ? 'is-invalid' : '' }}" type="text" name="delivery_term" id="delivery_term" value="{{ old('delivery_term', $purchaseOrder->delivery_term) }}" required>
                @if($errors->has('delivery_term'))
                    <span class="text-danger">{{ $errors->first('delivery_term') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.delivery_term_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="payment_term">{{ trans('cruds.purchase_order.fields.payment_term') }}</label>
                <input class="form-control {{ $errors->has('payment_term') ? 'is-invalid' : '' }}" type="text" name="payment_term" id="payment_term" value="{{ old('payment_term', $purchaseOrder->payment_term) }}" required>
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
        </form>
    </div>
</div>



@endsection