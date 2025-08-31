@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.par.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.par.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="reference" id="reference" hidden>
            <div class="form-group">
                <label class="required" for="ris_id">{{ trans('cruds.ris.fields.ris_no') }}</label>
                <select class="form-control {{ $errors->has('ris_id') ? 'is-invalid' : '' }}" name="ris_id" id="ris_id" required>
                    <option value="" disabled {{ old('ris_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($risData as $ris)
                        <option value="{{ $ris->id }}" 
                            data-reference="{{ $ris->ris_no }}" 
                            data-recipient="{{ $ris->recipient }}" 
                            data-designation="{{ $ris->designation }}" 
                            data-entity_name="{{ $ris->office }}" 
                            {{ old('ris_id') == $ris->id ? 'selected' : '' }}>
                            {{ $ris->ris_no }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('ris_id'))
                    <span class="text-danger">{{ $errors->first('ris_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ris.fields.ris_no_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.par.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', '') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par.fields.date_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="fund_cluster">{{ trans('cruds.par.fields.fund_cluster') }}</label>
                <input class="form-control {{ $errors->has('fund_cluster') ? 'is-invalid' : '' }}" type="text" name="fund_cluster" id="fund_cluster" value="{{ old('fund_cluster', '') }}" required>
                @if($errors->has('fund_cluster'))
                    <span class="text-danger">{{ $errors->first('datfund_clustere') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par.fields.fund_cluster_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="entity_name">{{ trans('cruds.par.fields.entity_name') }}</label>
                <input class="form-control {{ $errors->has('entity_name') ? 'is-invalid' : '' }}" type="text" name="entity_name" id="entity_name" value="{{ old('entity_name', '') }}" readonly required>
                @if($errors->has('entity_name'))
                    <span class="text-danger">{{ $errors->first('entity_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par.fields.entity_name_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="recipient">{{ trans('cruds.par.fields.recipient') }}</label>
                <input class="form-control {{ $errors->has('recipient') ? 'is-invalid' : '' }}" type="text" name="recipient" id="recipient" value="{{ old('recipient', '') }}" readonly required>
                @if($errors->has('recipient'))
                    <span class="text-danger">{{ $errors->first('recipient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par.fields.recipient_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.par.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', '') }}" readonly required>
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
@section('scripts')
@parent

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const risIdDropdown = document.getElementById('ris_id');
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