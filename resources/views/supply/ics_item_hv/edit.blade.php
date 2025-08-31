@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.ics_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.ics_item_hv.update", [$icsItemHv->id]) }}" enctype="multipart/form-data" id="edit_form" >
            @method('PUT')
            @csrf   
            <input type="text" name="id" id="id" value="{{ $icsItemHv->id }}" hidden>      
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.ics_item.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" readonly required>{{ $icsItemHv->description }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics_item.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="lifespan">{{ trans('cruds.ics_item.fields.lifespan') }}</label>
                <input class="form-control {{ $errors->has('lifespan') ? 'is-invalid' : '' }}" type="text" name="lifespan" id="lifespan" value="{{ old('lifespan', $icsItemHv->lifespan) }}">
                @if($errors->has('lifespan'))
                    <span class="text-danger">{{ $errors->first('lifespan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics_item.fields.lifespan_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="serial_no">{{ trans('cruds.ics_item.fields.serial_no') }}</label>
                <input class="form-control {{ $errors->has('serial_no') ? 'is-invalid' : '' }}" type="text" name="serial_no" id="serial_no" value="{{ old('serial_no', $icsItemHv->serial_no) }}">
                @if($errors->has('serial_no'))
                    <span class="text-danger">{{ $errors->first('serial_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics_item.fields.serial_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.ics_item.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" required>
                    <option value disabled {{ old('type',  $icsItemHv->type) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\IcsItemHv::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics_item.fields.type_helper') }}</span>
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