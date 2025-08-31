@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.par_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.par_item.update", [$parItem->id]) }}" enctype="multipart/form-data" id="edit_form" >
            @method('PUT')
            @csrf   
            <input type="text" name="id" id="id" value="{{ $parItem->id }}" hidden>      
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.par_item.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" readonly required>{{ $parItem->description }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par_item.fields.description_helper') }}</span>
            </div>      
            <div class="form-group">
                <label class="required" for="date_acquired">{{ trans('cruds.par_item.fields.date_acquired') }}</label>
                <input class="form-control date {{ $errors->has('date_acquired') ? 'is-invalid' : '' }}" type="text" name="date_acquired" id="date_acquired" value="{{ old('date_acquired', $parItem->date_acquired) }}">
                @if($errors->has('date_acquired'))
                    <span class="text-danger">{{ $errors->first('date_acquired') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par_item.fields.date_acquired_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="serial_no">{{ trans('cruds.par_item.fields.serial_no') }}</label>
                <input class="form-control {{ $errors->has('serial_no') ? 'is-invalid' : '' }}" type="text" name="serial_no" id="serial_no" value="{{ old('serial_no', $parItem->serial_no) }}">
                @if($errors->has('serial_no'))
                    <span class="text-danger">{{ $errors->first('serial_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par_item.fields.serial_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.par_item.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" required>
                    <option value disabled {{ old('type',  $parItem->type) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\ParItem::TYPE_SELECT as $key => $label)
                    <option value="{{ $key }}" {{ old('type', $parItem->type) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par_item.fields.type_helper') }}</span>
            </div>      
            <div class="form-group">
                <label class="required" for="specific_type">{{ trans('cruds.par_item.fields.specific_type') }}</label>
                <select class="form-control {{ $errors->has('specific_type') ? 'is-invalid' : '' }}" type="text" name="specific_type" id="specific_type" required>
                    <option value disabled {{ old('specific_type', $parItem->specific_type) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\ParItem::SPECIFIC_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('specific_type', $parItem->specific_type) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('specific_type'))
                    <span class="text-danger">{{ $errors->first('specific_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.par_item.fields.specific_type_helper') }}</span>
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