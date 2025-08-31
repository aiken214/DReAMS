@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.items_list.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.items_list.update", [$items_list->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="item_code">{{ trans('cruds.items_list.fields.item_code') }}</label>
                <input class="form-control {{ $errors->has('item_code') ? 'is-invalid' : '' }}" type="text" name="item_code" id="item_code" value="{{ old('item_code', $items_list->item_code) }}" required>
                @if($errors->has('item_code'))
                    <span class="text-danger">{{ $errors->first('item_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.items_list.fields.item_code_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.items_list.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description', $items_list->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.items_list.fields.description_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.items_list.fields.unit') }}</label>
                <select class="form-control select2 {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit" id="unit" required>
                    <option value disabled {{ old('unit', $items_list->unit) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->unit }}" {{ old('unit', $items_list->unit) == $unit->unit ? 'selected' : '' }}>
                            {{ $unit->unit }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.items_list.fields.unit_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="price">{{ trans('cruds.items_list.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', $items_list->price) }}" required>
                @if($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.items_list.fields.price_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="category">{{ trans('cruds.items_list.fields.category') }}</label>
                <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" name="category" id="category" value="{{ old('category', $items_list->category) }}" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\ItemsList::CATEGORY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('category', $items_list->category) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.items_list.fields.category_helper') }}</span>
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