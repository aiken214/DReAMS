@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.asset_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.asset_item.update", [$assetItem->id]) }}" enctype="multipart/form-data" id="edit_form" >
            @method('PUT')
            @csrf
            <input type="text" name="id" id="id" value="{{ $assetItem->id }}" hidden> 
            <input type="text" name="asset_id" id="asset_id" value="{{ $assetItem->asset_id }}" hidden> 
            <div class="form-group">
                <label class="required" for="description" hidden>{{ trans('cruds.asset_item.fields.description') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" readonly required>{{ old('description', $assetItem->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset_item.fields.description_helper') }}</span>
            </div>            
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.asset_item.fields.quantity') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', $assetItem->quantity) }}" required>
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset_item.fields.quantity_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.asset_item.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', $assetItem->type) }}" required>
                    <option value disabled {{ old('type',  null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\IarItem::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $assetItem->type) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset_item.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="category">{{ trans('cruds.asset_item.fields.category') }}</label>
                <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" name="category" id="category" value="{{ old('category', $assetItem->category) }}" required>
                    <option value disabled {{ old('category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\IarItem::CATEGORY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('category', $assetItem->category) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset_item.fields.category_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="status">{{ trans('cruds.asset_item.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', $assetItem->category) }}" status>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\IarItem::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $assetItem->status) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset_item.fields.status_helper') }}</span>
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