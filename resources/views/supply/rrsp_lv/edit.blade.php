@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.rrsp.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.rrsp_lv.update", [$rrspLv->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf            
            <div class="form-group">
                <label class="required" for="rrsp_lv_no">{{ trans('cruds.rrsp.fields.rrsp_no') }}</label>
                <input class="form-control {{ $errors->has('rrsp_lv_no') ? 'is-invalid' : '' }}" type="text" name="rrsp_lv_no" id="rrsp_lv_no" value="{{ old('rrsp_lv_no', $rrspLv->rrsp_lv_no) }}" readonly required>
                @if($errors->has('rrsp_lv_no'))
                    <span class="text-danger">{{ $errors->first('rrsp_lv_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.rrsp_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.rrsp.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $rrspLv->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="entity_name">{{ trans('cruds.rrsp.fields.entity_name') }}</label>
                <input class="form-control {{ $errors->has('entity_name') ? 'is-invalid' : '' }}" type="text" name="entity_name" id="entity_name" value="{{ old('entity_name', $rrspLv->ics_lv->entity_name) }}" readonly required>
                @if($errors->has('entity_name'))
                    <span class="text-danger">{{ $errors->first('entity_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.entity_name_helper') }}</span>
            </div>              
            <div class="form-group">
                <label class="required" for="recipient">{{ trans('cruds.rrsp.fields.recipient') }}</label>
                <input class="form-control {{ $errors->has('recipient') ? 'is-invalid' : '' }}" type="text" name="recipient" id="recipient" value="{{ old('recipient', $rrspLv->ics_lv->recipient) }}" readonly required>
                @if($errors->has('recipient'))
                    <span class="text-danger">{{ $errors->first('recipient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.recipient_helper') }}</span>
            </div>               
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.rrsp.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $rrspLv->ics_lv->designation) }}" readonly required>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.designation_helper') }}</span>
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