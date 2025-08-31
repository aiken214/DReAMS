@extends('layouts.admin')
@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.iirup.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.iirup.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="station" id="station"  hidden> 
            <div class="form-group">
                <label class="required" for="station_id">{{ trans('cruds.iirup.fields.station') }}</label>
                <select class="form-control {{ $errors->has('station_id') ? 'is-invalid' : '' }}" name="station_id" id="station_id" required>
                    <option value="" disabled {{ old('station_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($stations as $station)
                        <option value="{{ $station->id }}" 
                            data-station="{{ $station->station_name }}" 
                            data-accountable_officer="{{ $station->accountable_officer }}" 
                            data-position="{{ $station->position }}" 
                            {{ old('station_id') == $station->id ? 'selected' : '' }}>
                            {{ $station->station_name }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('station_id'))
                    <span class="text-danger">{{ $errors->first('station_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup.fields.station_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="accountable_officer">{{ trans('cruds.iirup.fields.accountable_officer') }}</label>
                <input class="form-control {{ $errors->has('accountable_officer') ? 'is-invalid' : '' }}" type="text" name="accountable_officer" id="accountable_officer" value="{{ old('accountable_officer', '') }}" readonly required>
                @if($errors->has('accountable_officer'))
                    <span class="text-danger">{{ $errors->first('accountable_officer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup.fields.accountable_officer_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="position">{{ trans('cruds.iirup.fields.position') }}</label>
                <input class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" type="text" name="position" id="position" value="{{ old('position', '') }}" readonly required>
                @if($errors->has('position'))
                    <span class="text-danger">{{ $errors->first('position') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup.fields.position_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.iirup.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', '') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="requester">{{ trans('cruds.iirup.fields.requester') }}</label>
                <select class="requester form-control {{ $errors->has('requester') ? 'is-invalid' : '' }}" name="requester" id="requester" required>
                    <option value disabled {{ old('requester', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->fullname }}" {{ old('requester') == $employee->fullname ? 'selected' : '' }}>
                            {{ $employee->fullname }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('requester'))
                    <span class="text-danger">{{ $errors->first('requester') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup.fields.requester_helper') }}</span>
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
@section('scripts')
@parent

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stationIdDropdown = document.getElementById('station_id');
        const stationField = document.getElementById('station');
        const accountable_officerField = document.getElementById('accountable_officer');
        const positionField = document.getElementById('position');

        stationIdDropdown.addEventListener('change', function () {
            const selectedOption = stationIdDropdown.options[stationIdDropdown.selectedIndex];
            const station = selectedOption.getAttribute('data-station');
            const accountable_officer = selectedOption.getAttribute('data-accountable_officer');
            const position = selectedOption.getAttribute('data-position');

            // Set the amount field's value
            stationField.value = station || ''; 
            accountable_officerField.value = accountable_officer || ''; 
            positionField.value = position || ''; 
        });
    });
</script>

@endsection