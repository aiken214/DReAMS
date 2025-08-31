@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.ppmp.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("user.ppmp.update", [$ppmp->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="fund_source">{{ trans('cruds.ppmp.fields.fund_source') }}</label>
                <input class="form-control {{ $errors->has('fund_source') ? 'is-invalid' : '' }}" type="text" name="fund_source" id="fund_source" value="{{ old('fund_source', $ppmp->fund_source) }}" readonly required>
                @if($errors->has('fund_source'))
                    <span class="text-danger">{{ $errors->first('fund_source') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ppmp.fields.fund_source_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="calendar_year">{{ trans('cruds.ppmp.fields.calendar_year') }}</label>
                <input class="form-control {{ $errors->has('calendar_year') ? 'is-invalid' : '' }}" type="text" name="calendar_year" id="calendar_year" value="{{ old('calendar_year', $ppmp->calendar_year) }}" required>
                @if($errors->has('calendar_year'))
                    <span class="text-danger">{{ $errors->first('calendar_year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ppmp.fields.calendar_year_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.ppmp.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $ppmp->title) }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ppmp.fields.title_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.ppmp.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', $ppmp->type) }}" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Ppmp::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $ppmp->type) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ppmp.fields.type_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="category">{{ trans('cruds.ppmp.fields.category') }}</label>
                <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" name="category" id="category" value="{{ old('category', $ppmp->category) }}" required>
                    <option value disabled {{ old('category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Ppmp::CATEGORY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('category', $ppmp->category) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ppmp.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="budget_alloc">{{ trans('cruds.ppmp.fields.budget_alloc') }}</label>
                <input class="form-control {{ $errors->has('budget_alloc') ? 'is-invalid' : '' }}" type="text" name="budget_alloc" id="budget_alloc" value="{{ old('budget_alloc', $ppmp->budget_alloc) }}" required>
                @if($errors->has('budget_alloc'))
                    <span class="text-danger">{{ $errors->first('budget_alloc') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ppmp.fields.budget_alloc_helper') }}</span>
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
        </form>
    </div>
</div>



@endsection