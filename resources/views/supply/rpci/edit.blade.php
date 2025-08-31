@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.rpci.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.rpci.update", [$rpci->id]) }}" enctype="multipart/form-data" id="edit_form" >
            @method('PUT')
            @csrf
            <input type="text" name="id" id="id" value="{{ $rpci->id }}" hidden> 

            <div class="form-group">
                <label class="required" for="article">{{ trans('cruds.rpci.fields.article') }}</label>
                <input rows="5" class="form-control {{ $errors->has('article') ? 'is-invalid' : '' }}" type="text" name="article" id="article" value="{{ old('article',  $rpci->article) }}" required></input>
                @if($errors->has('article'))
                    <span class="text-danger">{{ $errors->first('descrarticleiption') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.article_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.rpci.fields.description') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description"  required>{{ old('description', $rpci->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.description_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="stock_no">{{ trans('cruds.rpci.fields.stock_no') }}</label>
                <input class="form-control {{ $errors->has('stock_no') ? 'is-invalid' : '' }}" type="text" name="stock_no" id="stock_no" value="{{ old('stock_no', $rpci->stock_no) }}" required>
                @if($errors->has('stock_no'))
                    <span class="text-danger">{{ $errors->first('stock_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.stock_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.rpci.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" required>
                    <option value disabled {{ old('type',  $rpci->type) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Rpci::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.rpci.fields.unit') }}</label>
                <select class="unit form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit" id="unit" required>
                <option value="{{ $rpci->unit }}" selected>
                        {{ $rpci->unit }}
                    </option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->unit }}" {{ old('unit') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->unit }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.unit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit_value">{{ trans('cruds.rpci.fields.unit_value') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_value') ? 'is-invalid' : '' }}" type="text" name="unit_value" id="unit_value" value="{{ old('unit_value', $rpci->unit_value) }}" required>
                @if($errors->has('unit_value'))
                    <span class="text-danger">{{ $errors->first('unit_value') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.unit_value_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="quantity_property_card">{{ trans('cruds.rpci.fields.quantity_property_card') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity_property_card') ? 'is-invalid' : '' }}" type="text" name="quantity_property_card" id="quantity_property_card" value="{{ old('quantity_property_card', $rpci->quantity_property_card) }}" required>
                @if($errors->has('quantity_property_card'))
                    <span class="text-danger">{{ $errors->first('quantity_property_card') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.quantity_property_card_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="quantity_physical_count">{{ trans('cruds.rpci.fields.quantity_physical_count') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity_physical_count') ? 'is-invalid' : '' }}" type="text" name="quantity_physical_count" id="quantity_physical_count" value="{{ old('quantity_physical_count', $rpci->quantity_physical_count) }}" required>
                @if($errors->has('quantity_physical_count'))
                    <span class="text-danger">{{ $errors->first('quantity_physical_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.quantity_physical_count_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="quantity_so">{{ trans('cruds.rpci.fields.quantity_so') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity_so') ? 'is-invalid' : '' }}" type="text" name="quantity_so" id="quantity_so" value="{{ old('quantity_so', $rpci->quantity_so) }}" required>
                @if($errors->has('quantity_so'))
                    <span class="text-danger">{{ $errors->first('quantity_so') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.quantity_so_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="value_so">{{ trans('cruds.rpci.fields.value_so') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('value_so') ? 'is-invalid' : '' }}" type="text" name="value_so" id="value_so" value="{{ old('value_so', $rpci->value_so) }}" required>
                @if($errors->has('value_so'))
                    <span class="text-danger">{{ $errors->first('value_so') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.value_so_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="remarks">{{ trans('cruds.rpci.fields.remarks') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" required> {{ old('value_so', $rpci->remarks) }} </textarea>
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rpci.fields.remarks_helper') }}</span>
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