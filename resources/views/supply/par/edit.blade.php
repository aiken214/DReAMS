@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.par.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.par.update", [$par->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf            
            <div class="form-group">
                <label class="required" for="par_no">{{ trans('cruds.par.fields.par_no') }}</label>
                <input class="form-control {{ $errors->has('par_no') ? 'is-invalid' : '' }}" type="text" name="par_no" id="par_no" value="{{ old('par_no', $par->par_no) }}" readonly required>
                @if($errors->has('par_no'))
                    <span class="text-danger">{{ $errors->first('par_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par.fields.par_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.par.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $par->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par.fields.date_helper') }}</span>
            </div>                 
            <div class="form-group">
                <label class="required" for="fund_cluster">{{ trans('cruds.par.fields.fund_cluster') }}</label>
                <input class="form-control {{ $errors->has('fund_cluster') ? 'is-invalid' : '' }}" type="text" name="fund_cluster" id="fund_cluster" value="{{ old('fund_cluster', $par->fund_cluster) }}" required>
                @if($errors->has('fund_cluster'))
                    <span class="text-danger">{{ $errors->first('fund_cluster') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par.fields.fund_cluster_helper') }}</span>
            </div>             
            <div class="form-group">
                <label class="required" for="entity_name">{{ trans('cruds.par.fields.entity_name') }}</label>
                <input class="form-control {{ $errors->has('entity_name') ? 'is-invalid' : '' }}" type="text" name="entity_name" id="entity_name" value="{{ old('entity_name', $par->entity_name) }}" readonly required>
                @if($errors->has('entity_name'))
                    <span class="text-danger">{{ $errors->first('entity_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par.fields.entity_name_helper') }}</span>
            </div>              
            <div class="form-group">
                <label class="required" for="recipient">{{ trans('cruds.par.fields.recipient') }}</label>
                <input class="form-control {{ $errors->has('recipient') ? 'is-invalid' : '' }}" type="text" name="recipient" id="recipient" value="{{ old('recipient', $par->recipient) }}" readonly required>
                @if($errors->has('recipient'))
                    <span class="text-danger">{{ $errors->first('recipient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par.fields.recipient_helper') }}</span>
            </div>               
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.par.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $par->designation) }}" readonly required>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par.fields.designation_helper') }}</span>
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