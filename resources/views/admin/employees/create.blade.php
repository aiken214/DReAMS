@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employees.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="employee_no">{{ trans('cruds.employee.fields.deped_empid') }}</label>
                <input class="form-control {{ $errors->has('employee_no') ? 'is-invalid' : '' }}" type="text" name="employee_no" id="employee_no" value="{{ old('employee_no', '') }}" required>
                @if($errors->has('employee_no'))
                    <span class="text-danger">{{ $errors->first('employee_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.deped_empid_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="lastname">{{ trans('cruds.employee.fields.lastname') }}</label>
                <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', '') }}" required>
                @if($errors->has('lastname'))
                    <span class="text-danger">{{ $errors->first('lastname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.lastname_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="firstname">{{ trans('cruds.employee.fields.firstname') }}</label>
                <input class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" type="text" name="firstname" id="firstname" value="{{ old('firstname', '') }}" required>
                @if($errors->has('firstname'))
                    <span class="text-danger">{{ $errors->first('firstname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.firstname_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="middlename">{{ trans('cruds.employee.fields.middlename') }}</label>
                <input class="form-control {{ $errors->has('middlename') ? 'is-invalid' : '' }}" type="text" name="middlename" id="middlename" value="{{ old('middlename', '') }}">
                @if($errors->has('middlename'))
                    <span class="text-danger">{{ $errors->first('middlename') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.middlename_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ext_name">{{ trans('cruds.employee.fields.ext_name') }}</label>
                <input class="form-control {{ $errors->has('ext_name') ? 'is-invalid' : '' }}" type="text" name="ext_name" id="ext_name" value="{{ old('ext_name', '') }}">
                @if($errors->has('ext_name'))
                    <span class="text-danger">{{ $errors->first('ext_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.ext_name_helper') }}</span>
            </div>            
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.employee.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="position_id">{{ trans('cruds.employee.fields.position') }}</label>
                <select class="form-control select2 {{ $errors->has('position_id') ? 'is-invalid' : '' }}" name="position_id" id="position_id" required>
                    @foreach($positions as $id => $entry)
                        <option value="{{ $id }}" {{ old('position_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('position_id'))
                    <span class="text-danger">{{ $errors->first('position_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.position_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="station_id">{{ trans('cruds.employee.fields.assigned_station') }}</label>
                <select class="form-control select2 {{ $errors->has('station_id') ? 'is-invalid' : '' }}" name="station_id" id="station_id" required>
                    @foreach($stations as $id => $entry)
                        <option value="{{ $id }}" {{ old('station_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('station_id'))
                    <span class="text-danger">{{ $errors->first('station_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.assigned_station_helper') }}</span>
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