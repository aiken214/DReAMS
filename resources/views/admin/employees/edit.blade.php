@php
    use Carbon\Carbon;
@endphp

@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employees.update", [$employee->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="emp_id">{{ trans('cruds.employee.fields.deped_empid') }}</label>
                <input class="form-control {{ $errors->has('emp_id') ? 'is-invalid' : '' }}" type="text" name="emp_id" id="emp_id" value="{{ old('emp_id', $employee->emp_id) }}" required>
                @if($errors->has('emp_id'))
                    <span class="text-danger">{{ $errors->first('emp_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.deped_empid_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="lastname">{{ trans('cruds.employee.fields.lastname') }}</label>
                <input class="form-control {{ $errors->has('lname') ? 'is-invalid' : '' }}" type="text" name="lname" id="lname" value="{{ old('lname', $employee->lname) }}" required>
                @if($errors->has('lname'))
                    <span class="text-danger">{{ $errors->first('lname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.lastname_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="firstname">{{ trans('cruds.employee.fields.firstname') }}</label>
                <input class="form-control {{ $errors->has('fname') ? 'is-invalid' : '' }}" type="text" name="fname" id="fname" value="{{ old('fname', $employee->fname) }}" required>
                @if($errors->has('fname'))
                    <span class="text-danger">{{ $errors->first('fname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.firstname_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="middlename">{{ trans('cruds.employee.fields.middlename') }}</label>
                <input class="form-control {{ $errors->has('mname') ? 'is-invalid' : '' }}" type="text" name="mname" id="mname" value="{{ old('mname', $employee->mname) }}">
                @if($errors->has('mname'))
                    <span class="text-danger">{{ $errors->first('mname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.middlename_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ext_name">{{ trans('cruds.employee.fields.ext_name') }}</label>
                <input class="form-control {{ $errors->has('ext_name') ? 'is-invalid' : '' }}" type="text" name="ext_name" id="ext_name" value="{{ old('ext_name', $employee->ext_name) }}">
                @if($errors->has('ext_name'))
                    <span class="text-danger">{{ $errors->first('ext_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.ext_name_helper') }}</span>
            </div>
            <div class="form-group">               
                @php
                    $dateEquivalent = is_numeric($employee->birth_date)
                        ? Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($employee->birth_date - 1)
                        : null;                    
                    $birth_date = $dateEquivalent ? $dateEquivalent->toDateString() : $employee->birth_date;
                @endphp
                <label class="required" for="birth_date">{{ trans('cruds.employee.fields.birthdate') }}</label>
                <input class="form-control date {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="text" name="birth_date" id="birth_date" value="{{ old('birth_date', $birth_date) }}" required>
                @if($errors->has('birth_date'))
                    <span class="text-danger">{{ $errors->first('birth_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.birthdate_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="position">{{ trans('cruds.employee.fields.position') }}</label>
                <select class="form-control select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="designation" id="designation" required>
                    {{-- Include $employee->designation as an option --}}
                    <option value="{{ $employee->designation }}" selected>{{ $employee->designation }}</option>
                
                    {{-- Options loop --}}
                    @foreach($positions as $position)
                        {{-- Skip the option if it's already added --}}
                        @if($employee->designation != $position['position'])
                            <option value="{{ $position['position'] }}">{{ $position['position'] }}</option>
                        @endif
                    @endforeach
                </select>
                @if($errors->has('position'))
                    <span class="text-danger">{{ $errors->first('position') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.position_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="station_name">{{ trans('cruds.station.fields.station_name') }}</label>
                <select class="form-control select2 {{ $errors->has('office') ? 'is-invalid' : '' }}" name="office" id="office" required>
                    {{-- Include $employee->designation as an option --}}
                    <option value="{{ $employee->office }}" selected>{{ $employee->office }}</option>
                
                    {{-- Options loop --}}
                    @foreach($offices as $office)
                        {{-- Skip the option if it's already added --}}
                        @if($employee->office != $office['office'])
                            <option value="{{ $office['office'] }}">{{ $office['office'] }}</option>
                        @endif
                    @endforeach
                </select>
                @if($errors->has('office'))
                    <span class="text-danger">{{ $errors->first('office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.station.fields.station_name_helper') }}</span>
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