@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.iar.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.iar.update", [$iar->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf            
            <div class="form-group">
                <label class="required" for="iar_no">{{ trans('cruds.iar.fields.iar_no') }}</label>
                <input class="form-control {{ $errors->has('iar_no') ? 'is-invalid' : '' }}" type="text" name="iar_no" id="iar_no" value="{{ old('iar_no', $iar->iar_no) }}" readonly required>
                @if($errors->has('iar_no'))
                    <span class="text-danger">{{ $errors->first('iar_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.iar_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.iar.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $iar->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.date_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="invoice_no">{{ trans('cruds.iar.fields.invoice_no') }}</label>
                <input class="form-control {{ $errors->has('invoice_no') ? 'is-invalid' : '' }}" type="text" name="invoice_no" id="invoice_no" value="{{ old('invoice_no', $iar->invoice_no) }}" required>
                @if($errors->has('invoice_no'))
                    <span class="text-danger">{{ $errors->first('invoice_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.invoice_no_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="invoice_date">{{ trans('cruds.iar.fields.invoice_date') }}</label>
                <input class="form-control date {{ $errors->has('invoice_date') ? 'is-invalid' : '' }}" type="text" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', $iar->invoice_date) }}" required>
                @if($errors->has('invoice_date'))
                    <span class="text-danger">{{ $errors->first('invoice_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.invoice_date_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.iar.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', $iar->type) }}" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Iar::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $iar->type) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iar.fields.type_helper') }}</span>
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