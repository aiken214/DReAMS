@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.rrsp.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.rrsp_lv.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="reference" id="reference" hidden>
            <div class="form-group">
                <label class="required" for="ics_lv_id">{{ trans('cruds.ics.fields.ics_no') }}</label>
                <select class="form-control {{ $errors->has('ics_lv_id') ? 'is-invalid' : '' }}" name="ics_lv_id" id="ics_lv_id" required>
                    <option value="" disabled {{ old('ics_lv_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($icsLvs as $icsLv)
                        <option value="{{ $icsLv->id }}" 
                            data-reference="{{ $icsLv->ics_lv_no }}" 
                            data-recipient="{{ $icsLv->recipient }}" 
                            data-designation="{{ $icsLv->designation }}" 
                            data-entity_name="{{ $icsLv->entity_name }}" 
                            {{ old('ics_lv_id') == $icsLv->id ? 'selected' : '' }}>
                            {{ $icsLv->ics_lv_no }} - {{ $icsLv->recipient }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('ics_lv_id'))
                    <span class="text-danger">{{ $errors->first('ics_lv_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics.fields.ics_no_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.rrsp.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', '') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="entity_name">{{ trans('cruds.rrsp.fields.entity_name') }}</label>
                <input class="form-control {{ $errors->has('entity_name') ? 'is-invalid' : '' }}" type="text" name="entity_name" id="entity_name" value="{{ old('entity_name', '') }}" readonly required>
                @if($errors->has('entity_name'))
                    <span class="text-danger">{{ $errors->first('entity_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.entity_name_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="recipient">{{ trans('cruds.rrsp.fields.recipient') }}</label>
                <input class="form-control {{ $errors->has('recipient') ? 'is-invalid' : '' }}" type="text" name="recipient" id="recipient" value="{{ old('recipient', '') }}" readonly required>
                @if($errors->has('recipient'))
                    <span class="text-danger">{{ $errors->first('recipient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.recipient_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.rrsp.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', '') }}" readonly required>
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
@section('scripts')
@parent

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const risIdDropdown = document.getElementById('ics_lv_id');
        const referenceField = document.getElementById('reference');
        const recipientField = document.getElementById('recipient');
        const designationField = document.getElementById('designation');
        const entity_nameField = document.getElementById('entity_name');

        risIdDropdown.addEventListener('change', function () {
            const selectedOption = risIdDropdown.options[risIdDropdown.selectedIndex];
            const reference = selectedOption.getAttribute('data-reference');
            const recipient = selectedOption.getAttribute('data-recipient');
            const designation = selectedOption.getAttribute('data-designation');
            const entity_name = selectedOption.getAttribute('data-entity_name');

            // Set the amount field's value
            referenceField.value = reference || ''; // Default to empty if no amount is provided
            recipientField.value = recipient || ''; // Default to empty if no amount is provided
            designationField.value = designation || ''; // Default to empty if no amount is provided
            entity_nameField.value = entity_name || ''; // Default to empty if no amount is provided
        });
    });
</script>

@endsection