@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.rpcppe.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.rpcppe.store") }}" enctype="multipart/form-data" id="create_form" >
            @csrf
            <div class="form-group">
                <label class="required" for="article">{{ trans('cruds.rpcppe.fields.article') }}</label>
                <input rows="5" class="form-control {{ $errors->has('article') ? 'is-invalid' : '' }}" type="text" name="article" id="article" value="{{ old('article', '') }}" required></input>
                @if($errors->has('article'))
                    <span class="text-danger">{{ $errors->first('descrarticleiption') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.article_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.rpcppe.fields.description') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}" required></textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.description_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="property_no">{{ trans('cruds.rpcppe.fields.property_no') }}</label>
                <input class="form-control {{ $errors->has('property_no') ? 'is-invalid' : '' }}" type="text" name="property_no" id="property_no" value="{{ old('property_no', '') }}" required>
                @if($errors->has('property_no'))
                    <span class="text-danger">{{ $errors->first('property_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.property_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.rpcppe.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', '') }}" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Rpcppe::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.type_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="specific_type">{{ trans('cruds.rpcppe.fields.specific_type') }}</label>
                <select class="form-control {{ $errors->has('specific_type') ? 'is-invalid' : '' }}" type="text" name="specific_type" id="specific_type" value="{{ old('specific_type', '') }}" required>
                    <option value disabled {{ old('specific_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Rpcppe::SPECIFIC_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('specific_type', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('specific_type'))
                    <span class="text-danger">{{ $errors->first('specific_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.specific_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.rpcppe.fields.unit') }}</label>
                <select class="unit form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit" id="unit" required>
                    <option value disabled {{ old('unit', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->unit }}" {{ old('unit') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->unit }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit_value">{{ trans('cruds.rpcppe.fields.unit_value') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_value') ? 'is-invalid' : '' }}" type="text" name="unit_value" id="unit_value" value="{{ old('unit_value', '') }}" required>
                @if($errors->has('unit_value'))
                    <span class="text-danger">{{ $errors->first('unit_value') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.unit_value_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="quantity_property_card">{{ trans('cruds.rpcppe.fields.quantity_property_card') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity_property_card') ? 'is-invalid' : '' }}" type="text" name="quantity_property_card" id="quantity_property_card" value="{{ old('quantity_property_card', '') }}" required>
                @if($errors->has('quantity_property_card'))
                    <span class="text-danger">{{ $errors->first('quantity_property_card') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.quantity_property_card_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="quantity_physical_count">{{ trans('cruds.rpcppe.fields.quantity_physical_count') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity_physical_count') ? 'is-invalid' : '' }}" type="text" name="quantity_physical_count" id="quantity_physical_count" value="{{ old('quantity_physical_count', '') }}" required>
                @if($errors->has('quantity_physical_count'))
                    <span class="text-danger">{{ $errors->first('quantity_physical_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.quantity_physical_count_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="quantity_so">{{ trans('cruds.rpcppe.fields.so_quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity_so') ? 'is-invalid' : '' }}" type="text" name="quantity_so" id="quantity_so" value="{{ old('quantity_so', '') }}" required>
                @if($errors->has('quantity_so'))
                    <span class="text-danger">{{ $errors->first('quantity_so') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.quantity_so_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="value_so">{{ trans('cruds.rpcppe.fields.so_value') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('value_so') ? 'is-invalid' : '' }}" type="text" name="value_so" id="value_so" value="{{ old('value_so', '') }}" required>
                @if($errors->has('value_so'))
                    <span class="text-danger">{{ $errors->first('value_so') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.value_so_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="station_id">{{ trans('cruds.rpcppe.fields.station') }}</label>
                <select class="station_id form-control {{ $errors->has('station_id') ? 'is-invalid' : '' }}" name="station_id" id="station_id" required>
                    <option value disabled {{ old('station_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($stations as $station)
                        <option value="{{ $station->id }}" {{ old('station_id') == $station->id ? 'selected' : '' }}>
                            {{ $station->station_name }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('station'))
                    <span class="text-danger">{{ $errors->first('station') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.station_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="remarks">{{ trans('cruds.rpcppe.fields.remarks') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', '') }}" required></textarea>
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpcppe.fields.remarks_helper') }}</span>
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
</script>

@endsection
