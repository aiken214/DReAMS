@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.fund_obligation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("budget.fund_obligation.update", [$fundObligation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="text" name="purchase_order_id" id="purchase_order_id" value="{{ $fundObligation->purchase_order_id }}" hidden>
            <input type="text" name="fund_id" id="fund_id" value="{{ $fundObligation->fund_id }}" hidden>
            <div class="form-group">
                <label class="required" for="po_no">{{ trans('cruds.purchase_order.fields.po_no') }}</label>
                <input class="form-control {{ $errors->has('po_no') ? 'is-invalid' : '' }}" type="text" name="po_no" id="po_no" value="{{ old('po_no', $fundObligation->purchase_order->po_no) }}" readonly required>
                @if($errors->has('po_no'))
                    <span class="text-danger">{{ $errors->first('po_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_order.fields.po_no_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.fund_obligation.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $fundObligation->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund_obligation.fields.date_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="obr_no">{{ trans('cruds.fund_obligation.fields.obr_no') }}</label>
                <input class="form-control {{ $errors->has('obr_no') ? 'is-invalid' : '' }}" type="text" name="obr_no" id="obr_no" value="{{ old('obr_no', $fundObligation->obr_no) }}" required>
                @if($errors->has('obr_no'))
                    <span class="text-danger">{{ $errors->first('obr_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund_obligation.fields.obr_no_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.fund_obligation.fields.amount') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', $fundObligation->amount) }}" required>
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