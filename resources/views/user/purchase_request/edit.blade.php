@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.purchase_request.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("user.purchase_request.update", [$purchaseRequest->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label>{{ 'Purchase Request Number will be generated automatically once checked by the Supply Office.' }}</label>
            </div>
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.purchase_request.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $purchaseRequest->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request.fields.date_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="res_code">{{ trans('cruds.purchase_request.fields.res_code') }}</label>
                <input class="form-control {{ $errors->has('res_code') ? 'is-invalid' : '' }}" type="text" name="res_code" id="res_code" value="{{ old('res_code', $purchaseRequest->res_code) }}" required>
                @if($errors->has('res_code'))
                    <span class="text-danger">{{ $errors->first('res_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request.fields.res_code_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="fund_cluster">{{ trans('cruds.purchase_request.fields.fund_cluster') }}</label>
                <input class="form-control {{ $errors->has('fund_cluster') ? 'is-invalid' : '' }}" type="text" name="fund_cluster" id="fund_cluster" value="{{ old('fund_cluster', $purchaseRequest->fund_cluster) }}" required>
                @if($errors->has('fund_cluster'))
                    <span class="text-danger">{{ $errors->first('fund_cluster') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request.fields.fund_cluster_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="fund_source">{{ trans('cruds.purchase_request.fields.fund_source') }}</label>
                <input class="form-control {{ $errors->has('fund_source') ? 'is-invalid' : '' }}" type="text" name="fund_source" id="fund_source" value="{{ old('fund_source', $purchaseRequest->fund_source) }}" readonly required>
                @if($errors->has('fund_source'))
                    <span class="text-danger">{{ $errors->first('fund_source') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request.fields.fund_source_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="purpose">{{ trans('cruds.purchase_request.fields.purpose') }}</label>
                <textarea class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" type="text" name="purpose" id="purpose" required>{{ old('purpose', $purchaseRequest->purpose) }}</textarea>                    
                @if($errors->has('purpose'))
                    <span class="text-danger">{{ $errors->first('purpose') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request.fields.purpose_helper') }}</span>
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