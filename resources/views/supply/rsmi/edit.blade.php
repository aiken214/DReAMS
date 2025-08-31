@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.rsmi.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.rsmi.update", [$rsmi->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf            
            <div class="form-group">
                <label class="required" for="rsmi_no">{{ trans('cruds.rsmi.fields.rsmi_no') }}</label>
                <input class="form-control {{ $errors->has('rsmi_no') ? 'is-invalid' : '' }}" type="text" name="rsmi_no" id="rsmi_no" value="{{ old('rsmi_no', $rsmi->rsmi_no) }}" readonly required>
                @if($errors->has('rsmi_no'))
                    <span class="text-danger">{{ $errors->first('rsmi_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rsmi.fields.rsmi_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.rsmi.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $rsmi->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rsmi.fields.date_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="entity_name">{{ trans('cruds.rsmi.fields.entity_name') }}</label>
                <input class="form-control {{ $errors->has('entity_name') ? 'is-invalid' : '' }}" type="text" name="entity_name" id="entity_name" value="{{ old('entity_name', $rsmi->entity_name) }}" required>
                @if($errors->has('entity_name'))
                    <span class="text-danger">{{ $errors->first('entity_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rsmi.fields.entity_name_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="fund_cluster">{{ trans('cruds.rsmi.fields.fund_cluster') }}</label>
                <input class="form-control {{ $errors->has('fund_cluster') ? 'is-invalid' : '' }}" type="text" name="fund_cluster" id="fund_cluster" value="{{ old('fund_cluster', $rsmi->fund_cluster) }}" required>
                @if($errors->has('fund_cluster'))
                    <span class="text-danger">{{ $errors->first('fund_cluster') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rsmi.fields.fund_cluster_helper') }}</span>
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