@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.request_for_quotation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("bac.request_for_quotation.store") }}" enctype="multipart/form-data">
            @csrf
            <!-- <input type="text" name="ppmp_id" id="ppmp_id"  hidden>             -->
            <div class="form-group">
                <label class="required" for="purchase_request_id">{{ trans('cruds.request_for_quotation.fields.pr_no') }}</label>
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
                <span class="help-block">{{ trans('cruds.request_for_quotation.fields.pr_no_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.request_for_quotation.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', '') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.request_for_quotation.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="delivery_term">{{ trans('cruds.request_for_quotation.fields.delivery_term') }} {{ '(No.of Days)'}}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('delivery_term') ? 'is-invalid' : '' }}" type="text" name="delivery_term" id="delivery_term" value="{{ old('delivery_term', '') }}" required>
                @if($errors->has('delivery_term'))
                    <span class="text-danger">{{ $errors->first('delivery_term') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.request_for_quotation.fields.delivery_term_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="requirement">{{ trans('cruds.request_for_quotation.fields.requirement') }}</label>
                <input class="form-control {{ $errors->has('requirement') ? 'is-invalid' : '' }}" type="text" name="requirement" id="requirement" value="{{ old('requirement', '') }}" required>
                @if($errors->has('requirement'))
                    <span class="text-danger">{{ $errors->first('requirement') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.request_for_quotation.fields.requirement_helper') }}</span>
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