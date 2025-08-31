@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.iar.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.nod.update", [$iar->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf  
            <div class="form-group">
                <label class="required" for="invoice_no">{{ trans('cruds.iar.fields.nod_invoice_no') }}</label>
                <input class="form-control {{ $errors->has('invoice_no') ? 'is-invalid' : '' }}" type="text" name="invoice_no" id="invoice_no" value="{{ old('invoice_no', $iar->invoice_no) }}" required>
                @if($errors->has('invoice_no'))
                    <span class="text-danger">{{ $errors->first('invoice_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.nod_invoice_no_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="nod_date">{{ trans('cruds.iar.fields.nod_date') }}</label>
                <input class="form-control date {{ $errors->has('nod_date') ? 'is-invalid' : '' }}" type="text" name="nod_date" id="nod_date" value="{{ old('nod_date', $iar->nod_date) }}" required>
                @if($errors->has('nod_date'))
                    <span class="text-danger">{{ $errors->first('nod_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.nod_date_helper') }}</span>
            </div>            
            <div class="form-group">
                <label class="required" for="nod_time">{{ trans('cruds.iar.fields.nod_time') }}</label>
                <input class="form-control time {{ $errors->has('nod_time') ? 'is-invalid' : '' }}" type="time" name="nod_time" id="nod_time" value="{{ old('nod_time', $iar->nod_time) }}" required>
                @if($errors->has('nod_time'))
                    <span class="text-danger">{{ $errors->first('nod_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.nod_time_helper') }}</span>
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