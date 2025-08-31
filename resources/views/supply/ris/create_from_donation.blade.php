@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.ris.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.ris.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="employee_id" id="employee_id" hidden>
            <div class="form-group">
                <label class="required" for="donation_id">{{ trans('cruds.ris.fields.donation_no') }}</label>
                <select class="form-control {{ $errors->has('donation_id') ? 'is-invalid' : '' }}" name="donation_id" id="donation_id" required>
                    <option value="" disabled {{ old('donation_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($donations as $donation)
                        <option value="{{ $donation->id }}" 
                            data-purchase_order_id="{{ $donation->purchase_order_id }}" 
                            {{ old('donation_id') == $donation->id ? 'selected' : '' }}>
                            {{ $donation->donation_no }} - {{ $donation->purpose}}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('donation_id'))
                    <span class="text-danger">{{ $errors->first('donation_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris.fields.donation_no_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.ris.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', '') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris.fields.date_helper') }}</span>
            </div>               
            <div class="form-group">
                <label class="required" for="recipient">{{ trans('cruds.ris.fields.recipient') }}</label>
                <select class="unit form-control {{ $errors->has('recipient') ? 'is-invalid' : '' }}" name="recipient" id="recipient" required>
                    <option value disabled {{ old('recipient', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->fullname }}" 
                            data-employee_id="{{ $employee->id }}" 
                            {{ old('employee') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->fullname }} {{ $employee->id }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('recipient'))
                    <span class="text-danger">{{ $errors->first('recipient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris.fields.recipient_helper') }}</span>
            </div>            
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.ris.fields.designation') }}</label>
                <select class="unit form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="designation" id="designation" required>
                    <option value disabled {{ old('designation', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($designations as $designation)
                        <option value="{{ $designation->position }}" {{ old('designation') == $designation->id ? 'selected' : '' }}>
                            {{ $designation->position }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris.fields.designation_helper') }}</span>
            </div>                 
            <div class="form-group">
                <label class="required" for="office">{{ trans('cruds.ris.fields.office') }}</label>
                <select class="unit form-control {{ $errors->has('office') ? 'is-invalid' : '' }}" name="office" id="office" required>
                    <option value disabled {{ old('office', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($stations as $station)
                        <option value="{{ $station->station_name }}" {{ old('station') == $station->id ? 'selected' : '' }}>
                            {{ $station->station_name }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('office'))
                    <span class="text-danger">{{ $errors->first('office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris.fields.office_helper') }}</span>
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
        const recipientDropdown = document.getElementById('recipient');
        const employeeIdField = document.getElementById('employee_id');

        recipientDropdown.addEventListener('change', function () {
            const selectedOption = recipientDropdown.options[recipientDropdown.selectedIndex];
            const employee_id = selectedOption.getAttribute('data-employee_id');

            // Set the amount field's value
            employeeIdField.value = employee_id || ''; // Default to empty if no amount is provided
     
        });

    });
</script>

@endsection