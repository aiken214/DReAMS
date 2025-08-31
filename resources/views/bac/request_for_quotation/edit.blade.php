@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.request_for_quotation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("bac.request_for_quotation.update", [$requestForQuotation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="pr_no">{{ trans('cruds.request_for_quotation.fields.pr_no') }}</label>
                <input class="form-control {{ $errors->has('pr_no') ? 'is-invalid' : '' }}" type="text" name="pr_no" id="pr_no" value="{{ old('pr_no', $requestForQuotation->purchase_request->pr_no) }}" readonly required>
                @if($errors->has('pr_no'))
                    <span class="text-danger">{{ $errors->first('pr_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.request_for_quotation.fields.pr_no_helper') }}</span>
            </div>             
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.request_for_quotation.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $requestForQuotation->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.request_for_quotation.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="delivery_term">{{ trans('cruds.request_for_quotation.fields.delivery_term') }} {{ '(No.of Days)'}}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('delivery_term') ? 'is-invalid' : '' }}" type="text" name="delivery_term" id="delivery_term" value="{{ old('delivery_term', $requestForQuotation->delivery_term) }}" required>
                @if($errors->has('delivery_term'))
                    <span class="text-danger">{{ $errors->first('delivery_term') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.request_for_quotation.fields.delivery_term_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="requirement">{{ trans('cruds.request_for_quotation.fields.requirement') }}</label>
                <input class="form-control {{ $errors->has('requirement') ? 'is-invalid' : '' }}" type="text" name="requirement" id="requirement" value="{{ old('requirement', $requestForQuotation->requirement) }}" required>
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
        </form>
    </div>
</div>



@endsection