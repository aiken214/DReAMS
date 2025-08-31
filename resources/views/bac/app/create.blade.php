@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.app.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("bac.app.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="calendar_year">{{ trans('cruds.app.fields.calendar_year') }}</label>
                <input class="form-control {{ $errors->has('calendar_year') ? 'is-invalid' : '' }}" type="text" name="calendar_year" id="calendar_year" value="{{ old('calendar_year', '') }}" required>
                @if($errors->has('calendar_year'))
                    <span class="text-danger">{{ $errors->first('calendar_year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app.fields.calendar_year_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.app.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app.fields.title_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.app.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', '') }}" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Ppmp::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app.fields.type_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="category">{{ trans('cruds.app.fields.category') }}</label>
                <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" name="category" id="category" value="{{ old('category', '') }}" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Ppmp::CATEGORY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('category', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app.fields.category_helper') }}</span>
            </div>          
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.app.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', '') }}"></textarea>
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.app.fields.remarks_helper') }}</span>
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