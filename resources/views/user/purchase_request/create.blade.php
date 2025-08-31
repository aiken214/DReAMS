@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.purchase_request.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("user.purchase_request.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="ppmp_id" id="ppmp_id" hidden>

            <div class="form-group">
                <label>{{ 'Purchase Request Number will be generated automatically once checked by the Supply Office.' }}</label>
            </div>   
            
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.purchase_request.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', '') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request.fields.date_helper') }}</span>
            </div>          

            <div class="form-group">
                <label class="required" for="res_code">{{ trans('cruds.purchase_request.fields.res_code') }}</label>
                <input class="form-control {{ $errors->has('res_code') ? 'is-invalid' : '' }}" type="text" name="res_code" id="res_code" value="{{ old('res_code', '') }}" required>
                @if($errors->has('res_code'))
                    <span class="text-danger">{{ $errors->first('res_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request.fields.res_code_helper') }}</span>
            </div> 

            <div class="form-group">
                <label class="required" for="fund_cluster">{{ trans('cruds.purchase_request.fields.fund_cluster') }}</label>
                <input class="form-control {{ $errors->has('fund_cluster') ? 'is-invalid' : '' }}" type="text" name="fund_cluster" id="fund_cluster" value="{{ old('fund_cluster', '') }}" required>
                @if($errors->has('fund_cluster'))
                    <span class="text-danger">{{ $errors->first('fund_cluster') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request.fields.fund_cluster_helper') }}</span>
            </div>  

            <div class="form-group">
                <label class="required" for="fund_id">{{ trans('cruds.ppmp.fields.fund_source') }}</label>
                <select class="form-control {{ $errors->has('fund_id') ? 'is-invalid' : '' }}" name="fund_id" id="fund_id" required>
                    <option value="" disabled {{ old('fund_id', null) === null ? 'selected' : '' }}>
                        Please Select
                    </option>
                    @foreach($fundSources as $fundSource)
                        @php 
                            $ppmp = $fundSource->ppmp->first(); 
                        @endphp
                        <option value="{{ $fundSource->id }}" 
                            data-amount="{{ $ppmp->budget_alloc ?? 'NO BUDGET' }}" 
                            data-purpose="{{ $ppmp->title ?? 'NO PURPOSE' }}"  
                            data-ppmp_id="{{ $ppmp->id ?? 'NO PPMP_ID' }}"  
                            {{ old('fund_id') == $fundSource->id ? 'selected' : '' }}>
                            {{ $fundSource->legal_basis }}
                        </option>
                    @endforeach 
                </select>
                @if($errors->has('fund_id'))
                    <span class="text-danger">{{ $errors->first('fund_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ppmp.fields.fund_source_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="purpose">{{ trans('cruds.purchase_request.fields.purpose') }}</label>
                <textarea class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" 
                    name="purpose" 
                    id="purpose" 
                    required>{{ old('purpose', '') }}</textarea>
                @if($errors->has('purpose'))
                    <span class="text-danger">{{ $errors->first('purpose') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.purchase_request.fields.purpose_helper') }}</span>
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
    const fund_idDropdown = document.getElementById('fund_id');
    const purposeField = document.getElementById('purpose');
    const ppmp_idField = document.getElementById('ppmp_id');

    fund_idDropdown.addEventListener('change', function () {
        const selectedOption = fund_idDropdown.options[fund_idDropdown.selectedIndex];
        const purpose = selectedOption.getAttribute('data-purpose') || ''; 
        const ppmp_id = selectedOption.getAttribute('data-ppmp_id') || ''; 

        // console.log("Selected Purpose:", purpose);
        // console.log("Selected PPMP_ID:", ppmp_id);

        purposeField.value = purpose;
        ppmp_idField.value = ppmp_id;
    });
});
</script>

@endsection