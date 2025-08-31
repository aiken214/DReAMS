@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.ics.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.ics_lv.update", [$icsLv->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf            
            <div class="form-group">
                <label class="required" for="ics_lv_no">{{ trans('cruds.ics.fields.ics_no') }}</label>
                <input class="form-control {{ $errors->has('ics_lv_no') ? 'is-invalid' : '' }}" type="text" name="ics_lv_no" id="ics_lv_no" value="{{ old('ics_lv_no', $icsLv->ics_lv_no) }}" readonly required>
                @if($errors->has('ics_lv_no'))
                    <span class="text-danger">{{ $errors->first('ics_lv_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics.fields.ics_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.ics.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $icsLv->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics.fields.date_helper') }}</span>
            </div>                 
            <div class="form-group">
                <label class="required" for="fund_cluster">{{ trans('cruds.ics.fields.fund_cluster') }}</label>
                <input class="form-control {{ $errors->has('fund_cluster') ? 'is-invalid' : '' }}" type="text" name="fund_cluster" id="fund_cluster" value="{{ old('fund_cluster', $icsLv->fund_cluster) }}" required>
                @if($errors->has('fund_cluster'))
                    <span class="text-danger">{{ $errors->first('fund_cluster') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics.fields.fund_cluster_helper') }}</span>
            </div>             
            <div class="form-group">
                <label class="required" for="entity_name">{{ trans('cruds.ics.fields.entity_name') }}</label>
                <input class="form-control {{ $errors->has('entity_name') ? 'is-invalid' : '' }}" type="text" name="entity_name" id="entity_name" value="{{ old('entity_name', $icsLv->entity_name) }}" readonly required>
                @if($errors->has('entity_name'))
                    <span class="text-danger">{{ $errors->first('entity_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics.fields.entity_name_helper') }}</span>
            </div>              
            <div class="form-group">
                <label class="required" for="recipient">{{ trans('cruds.ics.fields.recipient') }}</label>
                <input class="form-control {{ $errors->has('recipient') ? 'is-invalid' : '' }}" type="text" name="recipient" id="recipient" value="{{ old('recipient', $icsLv->recipient) }}" readonly required>
                @if($errors->has('recipient'))
                    <span class="text-danger">{{ $errors->first('recipient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics.fields.recipient_helper') }}</span>
            </div>               
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.ics.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $icsLv->designation) }}" readonly required>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics.fields.designation_helper') }}</span>
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