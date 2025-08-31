@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.signatory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.signatory.update", [$signatory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="fullname">{{ trans('cruds.signatory.fields.fullname') }}</label>
                <input class="form-control {{ $errors->has('fullname') ? 'is-invalid' : '' }}" type="text" name="fullname" id="fullname" value="{{ old('fullname', $signatory->fullname) }}" required>
                @if($errors->has('fullname'))
                    <span class="text-danger">{{ $errors->first('fullname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.signatory.fields.fullname_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="position">{{ trans('cruds.signatory.fields.position') }}</label>
                <select class="position form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" name="position" id="position" required>
                    <option value disabled {{ old('position', $signatory->position) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->position }}" {{ old('position', $signatory->position) == $signatory->position ? 'selected' : '' }}>
                            {{ $position->position }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('position'))
                    <span class="text-danger">{{ $errors->first('position') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.signatory.fields.position_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="document">{{ trans('cruds.signatory.fields.document') }}</label>
                <select class="form-control {{ $errors->has('document') ? 'is-invalid' : '' }}" type="text" name="document" id="document" value="{{ old('document', $signatory->document) }}" required>
                    <option value disabled {{ old('document', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Signatory::DOCUMENT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('document', $signatory->document) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('document'))
                    <span class="text-danger">{{ $errors->first('document') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.signatory.fields.document_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="type_goods">{{ trans('cruds.signatory.fields.type_goods') }}</label>
                <select class="form-control {{ $errors->has('type_goods') ? 'is-invalid' : '' }}" type="text" name="type_goods" id="type_goods" value="{{ old('type_goods', $signatory->type_goods) }}" required>
                    <option value disabled {{ old('type_goods', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Signatory::TYPE_GOODS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type_goods', $signatory->type_goods) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type_goods'))
                    <span class="text-danger">{{ $errors->first('type_goods') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.signatory.fields.type_goods_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.signatory.fields.designation') }}</label>
                <select class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $signatory->designation) }}" required>
                    <option value disabled {{ old('designation', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Signatory::DESIGNATION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('designation', $signatory->designation) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.signatory.fields.designation_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="role">{{ trans('cruds.signatory.fields.role') }}</label>
                <select class="form-control {{ $errors->has('fund_source') ? 'is-invalid' : '' }}" type="text" name="role" id="role" value="{{ old('role', $signatory->role) }}" required>
                    <option value disabled {{ old('role', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Signatory::ROLE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('role', $signatory->role) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('role'))
                    <span class="text-danger">{{ $errors->first('role') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.signatory.fields.role_helper') }}</span>
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