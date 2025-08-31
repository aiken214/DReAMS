@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.app_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("bac.app_item.store") }}" enctype="multipart/form-data">
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
                <label class="required" for="epa">{{ trans('cruds.app_item.fields.epa') }}</label>
                <select class="form-control {{ $errors->has('epa') ? 'is-invalid' : '' }}" type="text" name="epa" id="epa" value="{{ old('epa', '') }}" required>
                    <option value disabled {{ old('epa', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\AppItem::EPA_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('epa', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('epa'))
                    <span class="text-danger">{{ $errors->first('epa') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app_item.fields.epa_helper') }}</span>
            </div>                                 
            <div class="form-group">
                <label class="required" for="mode">{{ trans('cruds.app_item.fields.mode') }}</label>
                <select class="form-control {{ $errors->has('mode') ? 'is-invalid' : '' }}" type="text" name="mode" id="mode" value="{{ old('mode', '') }}" required>
                    <option value disabled {{ old('mode', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\AppItem::MODE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('mode', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('mode'))
                    <span class="text-danger">{{ $errors->first('mode') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app_item.fields.mode_helper') }}</span>
            </div>  
            <div class="form-group">
                <label for="posting">{{ trans('cruds.app_item.fields.posting') }}</label>
                <input class="form-control date{{ $errors->has('posting') ? 'is-invalid' : '' }}" type="text" name="posting" id="posting" value="{{ old('posting', '') }}" >
                @if($errors->has('posting'))
                    <span class="text-danger">{{ $errors->first('posting') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app_item.fields.posting_helper') }}</span>
            </div>  
            <div class="form-group">
                <label for="opening">{{ trans('cruds.app_item.fields.opening') }}</label>
                <input class="form-control date{{ $errors->has('opening') ? 'is-invalid' : '' }}" type="text" name="opening" id="opening" value="{{ old('opening', '') }}" >
                @if($errors->has('opening'))
                    <span class="text-danger">{{ $errors->first('opening') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app_item.fields.opening_helper') }}</span>
            </div>  
            <div class="form-group">
                <label for="noa">{{ trans('cruds.app_item.fields.noa') }}</label>
                <input class="form-control date{{ $errors->has('noa') ? 'is-invalid' : '' }}" type="text" name="noa" id="noa" value="{{ old('noa', '') }}" >
                @if($errors->has('noa'))
                    <span class="text-danger">{{ $errors->first('noa') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app_item.fields.noa_helper') }}</span>
            </div>  
            <div class="form-group">
                <label for="contract">{{ trans('cruds.app_item.fields.contract') }}</label>
                <input class="form-control date{{ $errors->has('contract') ? 'is-invalid' : '' }}" type="text" name="contract" id="contract" value="{{ old('contract', '') }}" >
                @if($errors->has('contract'))
                    <span class="text-danger">{{ $errors->first('contract') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app_item.fields.contract_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="remarks">{{ trans('cruds.app_item.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', '') }}" required></textarea>
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app_item.fields.remarks_helper') }}</span>
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
        const ppmp_idDropdown = document.getElementById('ppmp_id');
        const enduserField = document.getElementById('enduser');;
        const amountField = document.getElementById('amount');

        ppmp_idDropdown.addEventListener('change', function () {
            const selectedOption = ppmp_idDropdown.options[ppmp_idDropdown.selectedIndex];
            const prepared_by = selectedOption.getAttribute('data-prepared_by');
            const budget_alloc = selectedOption.getAttribute('data-budget_alloc');

            // Set the field's value
            enduserField.value = prepared_by || '';
            amountField.value = budget_alloc || '';
        });
    });
</script>

@endsection