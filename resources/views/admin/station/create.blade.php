@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.station.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.station.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="station_id">{{ trans('cruds.station.fields.station_id') }}</label>
                <input class="form-control {{ $errors->has('station_id') ? 'is-invalid' : '' }}" type="text" name="station_id" id="station_id" value="{{ old('station_id', '') }}" required>
                @if($errors->has('station_id'))
                    <span class="text-danger">{{ $errors->first('station_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.station.fields.station_id_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="station_name">{{ trans('cruds.station.fields.station_name') }}</label>
                <input class="form-control {{ $errors->has('station_name') ? 'is-invalid' : '' }}" type="text" name="station_name" id="station_name" value="{{ old('station_name', '') }}" required>
                @if($errors->has('station_name'))
                    <span class="text-danger">{{ $errors->first('station_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.station.fields.station_name_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="category">{{ trans('cruds.common.fields.category') }}</label>
                <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" name="category" id="category" value="{{ old('category', '') }}" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Station::CATEGORY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('category', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.common.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="accountable_officer">{{ trans('cruds.station.fields.accountable_officer') }}</label>
                <select class="accountable_officer form-control {{ $errors->has('accountable_officer') ? 'is-invalid' : '' }}" name="accountable_officer" id="accountable_officer" required>
                    <option value disabled {{ old('accountable_officer', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->fullname }}" {{ old('user') == $user->fullname ? 'selected' : '' }}>
                            {{ $user->fullname }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('accountable_officer'))
                    <span class="text-danger">{{ $errors->first('accountable_officer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.station.fields.accountable_officer_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="position">{{ trans('cruds.station.fields.position') }}</label>
                <select class="unit form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="position" id="position" required>
                    <option value disabled {{ old('position', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->position }}" {{ old('position') == $position->position ? 'selected' : '' }}>
                            {{ $position->position }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('position'))
                    <span class="text-danger">{{ $errors->first('position') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.station.fields.position_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="assumed_date">{{ trans('cruds.station.fields.assumed_date') }}</label>
                <input class="form-control date {{ $errors->has('assumed_date') ? 'is-invalid' : '' }}" type="text" name="assumed_date" id="assumed_date" value="{{ old('assumed_date', '') }}" required>
                @if($errors->has('assumed_date'))
                    <span class="text-danger">{{ $errors->first('assumed_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.station.fields.assumed_date_helper') }}</span>
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