@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.rsmi.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.rsmi.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="type" id="type" hidden>
            <input type="text" name="entity_name" id="entity_name" value="Department of Education - Division of Davao del Norte" hidden>
            <input type="text" name="fund_cluster" id="fund_cluster" value="01" hidden>
            <div class="form-group">
                <label>{{ 'RSMI Number will be generated automatically.' }}</label>
            </div>
            <div class="form-group">
                <label class="required" for="reference_id">{{ trans('cruds.rsmi.fields.reference') }}</label>
                <select class="form-control {{ $errors->has('reference_id') ? 'is-invalid' : '' }}" name="reference_id" id="reference_id" required>
                    <option value="" disabled {{ old('reference_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($mergedItems as $mergedItem)
                        <option value="{{ $mergedItem['id'] }}" 
                            data-type="{{ $mergedItem['type'] }}"
                            {{ old('mergedItem') == $mergedItem['id'] ? 'selected' : '' }}>
                            {{ $mergedItem['number'] }} - {{ $mergedItem['from'] }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('reference_id'))
                    <span class="text-danger">{{ $errors->first('reference_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rsmi.fields.reference_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.rsmi.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', '') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rsmi.fields.date_helper') }}</span>
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
        const referenceIdDropdown = document.getElementById('reference_id');
        const typeField = document.getElementById('type');

        referenceIdDropdown.addEventListener('change', function () {
            const selectedOption = referenceIdDropdown.options[referenceIdDropdown.selectedIndex];
            const type = selectedOption.getAttribute('data-type');

            // Set the amount field's value
            typeField.value = type || ''; // Default to empty if no amount is provided
        });
    });
</script>

@endsection