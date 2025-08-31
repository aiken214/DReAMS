@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.rpcsp.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.rpcsp.store_from_ics_hv") }}" enctype="multipart/form-data" id="create_form" >
            @csrf            
            <div class="form-group">
                <label class="required" for="ics_item_hv_id">{{ trans('cruds.common.fields.search_item') }}</label>
                <select class="form-control {{ $errors->has('ics_item_hv_id') ? 'is-invalid' : '' }}" name="ics_item_hv_id" id="ics_item_hv_id" readonly required>
                    <option value="" disabled {{ old('ics_item_hv_id', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($icsItems as $icsItem)
                        <option value="{{ $icsItem->id }}" 
                            data-ics_item_hv_id="{{ $icsItem->ics_item_hv_id }}" 
                            data-description="{{ $icsItem->description }}" 
                            data-property_no="{{ $icsItem->inventory_item_no }}" 
                            data-type="{{ $icsItem->type }}" 
                            data-specific_type="{{ $icsItem->specific_type }}" 
                            data-unit="{{ $icsItem->unit }}" 
                            data-unit_value="{{ $icsItem->total_cost }}" 
                            data-station="{{ $icsItem->ics_hv->entity_name }}" 
                            {{ old('ics_item_hv_id') == $icsItem->id ? 'selected' : '' }}>
                            {{ $icsItem->ics_hv->ics_hv_no }} - {{ $icsItem->ics_hv->recipient }} - {{ Str::limit(optional($icsItem->first())->description, 120) }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('ics_item_hv_id'))
                    <span class="text-danger">{{ $errors->first('ics_item_hv_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.common.fields.search_item_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.rpcsp.fields.description') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}" readonly></textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.description_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="sp_property_no">{{ trans('cruds.rpcsp.fields.sp_property_no') }}</label>
                <input class="form-control {{ $errors->has('sp_property_no') ? 'is-invalid' : '' }}" type="text" name="sp_property_no" id="sp_property_no" value="{{ old('sp_property_no', '') }}" readonly required>
                @if($errors->has('sp_property_no'))
                    <span class="text-danger">{{ $errors->first('sp_property_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.sp_property_no_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.rpcsp.fields.type') }}</label>
                <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', '') }}" readonly required>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.type_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.rpcsp.fields.unit') }}</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', '') }}" readonly required>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit_value">{{ trans('cruds.rpcsp.fields.unit_value') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_value') ? 'is-invalid' : '' }}" type="text" name="unit_value" id="unit_value" value="{{ old('unit_value', '') }}" readonly required>
                @if($errors->has('unit_value'))
                    <span class="text-danger">{{ $errors->first('unit_value') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.unit_value_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="station">{{ trans('cruds.rpcsp.fields.station') }}</label>
                <input rows="5" class="form-control {{ $errors->has('artistationcle') ? 'is-invalid' : '' }}" type="text" name="station" id="station" value="{{ old('station', '') }}" readonly required></input>
                @if($errors->has('station'))
                    <span class="text-danger">{{ $errors->first('station') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.station_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="article">{{ trans('cruds.rpcsp.fields.article') }}</label>
                <input rows="5" class="form-control {{ $errors->has('article') ? 'is-invalid' : '' }}" type="text" name="article" id="article" value="{{ old('article', '') }}" required></input>
                @if($errors->has('article'))
                    <span class="text-danger">{{ $errors->first('article') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.article_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="quantity_property_card">{{ trans('cruds.rpcsp.fields.quantity_property_card') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity_property_card') ? 'is-invalid' : '' }}" type="text" name="quantity_property_card" id="quantity_property_card" value="{{ old('quantity_property_card', '') }}" required>
                @if($errors->has('quantity_property_card'))
                    <span class="text-danger">{{ $errors->first('quantity_property_card') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.quantity_property_card_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="quantity_physical_count">{{ trans('cruds.rpcsp.fields.quantity_physical_count') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity_physical_count') ? 'is-invalid' : '' }}" type="text" name="quantity_physical_count" id="quantity_physical_count" value="{{ old('quantity_physical_count', '') }}" required>
                @if($errors->has('quantity_physical_count'))
                    <span class="text-danger">{{ $errors->first('quantity_physical_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.quantity_physical_count_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="quantity_so">{{ trans('cruds.rpcsp.fields.quantity_so') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity_so') ? 'is-invalid' : '' }}" type="text" name="quantity_so" id="quantity_so" value="{{ old('quantity_so', '') }}" required>
                @if($errors->has('quantity_so'))
                    <span class="text-danger">{{ $errors->first('quantity_so') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.quantity_so_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="value_so">{{ trans('cruds.rpcsp.fields.value_so') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('value_so') ? 'is-invalid' : '' }}" type="text" name="value_so" id="value_so" value="{{ old('value_so', '') }}" required>
                @if($errors->has('value_so'))
                    <span class="text-danger">{{ $errors->first('value_so') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.value_so_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="remarks">{{ trans('cruds.rpcsp.fields.remarks') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', '') }}" required></textarea>
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcsp.fields.remarks_helper') }}</span>
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

<script>
    $(document).ready(function () {
        // Accept numbers and allow "-" only at the beginning
        $('.numbers').keyup(function () { 
            this.value = this.value.replace(/[^0-9.-]/g, ''); // Allow numbers, ".", and "-"
            
            // Ensure "-" is only at the beginning
            if (this.value.indexOf('-') > 0) {
                this.value = this.value.replace('-', '');
            }
        });   
    });

    document.addEventListener('DOMContentLoaded', function () {
        const parItemIdDropdown = document.getElementById('ics_item_hv_id');
        const descriptionField = document.getElementById('description');
        const property_noField = document.getElementById('sp_property_no');
        const typeField = document.getElementById('type');
        const unitField = document.getElementById('unit');
        const unit_valueField = document.getElementById('unit_value');
        const stationField = document.getElementById('station');

        parItemIdDropdown.addEventListener('change', function () {
            const selectedOption = parItemIdDropdown.options[parItemIdDropdown.selectedIndex];
            const description = selectedOption.getAttribute('data-description');
            const property_no = selectedOption.getAttribute('data-sp_property_no');
            const type = selectedOption.getAttribute('data-type');
            const unit = selectedOption.getAttribute('data-unit');
            const unit_value = selectedOption.getAttribute('data-unit_value');
            const station = selectedOption.getAttribute('data-station');

            // Set the amount field's value
            descriptionField.value = description || ''; 
            property_noField.value = property_no || ''; 
            typeField.value = type || ''; 
            unitField.value = unit || ''; 
            unit_valueField.value = unit_value || ''; 
            stationField.value = station || ''; 
        });
    });
</script>

@endsection
