@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.supplier.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("bac.supplier.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.supplier.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.supplier.fields.name_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.supplier.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}" required>
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.supplier.fields.address_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="tin">{{ trans('cruds.supplier.fields.tin') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="tin" id="tin" value="{{ old('tin', '') }}" required>
                @if($errors->has('tin'))
                    <span class="text-danger">{{ $errors->first('tin') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.supplier.fields.tin_helper') }}</span>
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