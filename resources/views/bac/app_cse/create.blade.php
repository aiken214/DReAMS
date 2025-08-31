@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.app_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("bac.app_cse.store") }}" enctype="multipart/form-data">
            @csrf 
            <input type="text" name="app_id" id="app_id" value="{{ $id }}" hidden>
            <div class="form-group">
                <label class="required" for="ppmp_id">{{ trans('cruds.app_item.fields.ppmp') }}</label>
                <select class="form-control {{ $errors->has('ppmp') ? 'is-invalid' : '' }}" name="ppmp_id" id="ppmp_id" readonly required>
                    <option value disabled {{ old('ppmp_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($ppmps as $ppmp)
                        <option value="{{ $ppmp->id }}" 
                            data-prepared_by="{{ $ppmp->prepared_by }}" 
                            data-budget_alloc="{{ $ppmp->budget_alloc }}" 
                            {{ old('ppmp_id') == $ppmp->id ? 'selected' : '' }}>
                            {{ $ppmp->title }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('ppmp'))
                    <span class="text-danger">{{ $errors->first('ppmp') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app_item.fields.ppmp_helper') }}</span>
            </div>         
            <div class="form-group">
                <label class="required" for="enduser">{{ trans('cruds.app_item.fields.enduser') }}</label>
                <input class="form-control {{ $errors->has('enduser') ? 'is-invalid' : '' }}" type="text" name="enduser" id="enduser" value="{{ old('enduser', '') }}" readonly required>
                @if($errors->has('enduser'))
                    <span class="text-danger">{{ $errors->first('enduser') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app_item.fields.enduser_helper') }}</span>
            </div>                     
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.app_item.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', '') }}" readonly required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app_item.fields.amount_helper') }}</span>
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
        const ppmpDropdown = document.getElementById('ppmp_id');
        const enduserField = document.getElementById('enduser');
        const amountField = document.getElementById('amount');

        ppmpDropdown.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];

            if (selectedOption) {
                enduserField.value = selectedOption.getAttribute('data-prepared_by') || '';
                amountField.value = selectedOption.getAttribute('data-budget_alloc') || '';
            }
        });

        // Set initial values if preselected
        if (ppmpDropdown.value) {
            const selectedOption = ppmpDropdown.options[ppmpDropdown.selectedIndex];
            enduserField.value = selectedOption.getAttribute('data-prepared_by') || '';
            amountField.value = selectedOption.getAttribute('data-budget_alloc') || '';
        }
    });
</script>

@endsection