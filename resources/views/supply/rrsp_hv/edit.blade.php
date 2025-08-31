@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.rrsp.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.rrsp_hv.update", [$rrspHv->id]) }}" encserviceability="multipart/form-data">
            @method('PUT')
            @csrf            
            <div class="form-group">
                <label class="required" for="rrsp_hv_no">{{ trans('cruds.rrsp.fields.rrsp_no') }}</label>
                <input class="form-control {{ $errors->has('rrsp_hv_no') ? 'is-invalid' : '' }}" serviceability="text" name="rrsp_hv_no" id="rrsp_hv_no" value="{{ old('rrsp_hv_no', $rrspHv->rrsp_hv_no) }}" readonly required>
                @if($errors->has('rrsp_hv_no'))
                    <span class="text-danger">{{ $errors->first('rrsp_hv_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.rrsp_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.rrsp.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" serviceability="text" name="date" id="date" value="{{ old('date', $rrspHv->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.date_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="serviceability">{{ trans('cruds.rrsp.fields.serviceability') }}</label>
                <select class="form-control {{ $errors->has('serviceability') ? 'is-invalid' : '' }}" serviceability="text" name="serviceability" id="serviceability" required>
                    <option value disabled {{ old('serviceability',  $rrspHv->ics_hv->ics_item_hv->serviceability) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\RrspHv::SERVICEABILITY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('serviceability', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('serviceability'))
                    <span class="text-danger">{{ $errors->first('serviceability') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.serviceability_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="entity_name">{{ trans('cruds.rrsp.fields.entity_name') }}</label>
                <input class="form-control {{ $errors->has('entity_name') ? 'is-invalid' : '' }}" serviceability="text" name="entity_name" id="entity_name" value="{{ old('entity_name', $rrspHv->ics_hv->entity_name) }}" readonly required>
                @if($errors->has('entity_name'))
                    <span class="text-danger">{{ $errors->first('entity_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.entity_name_helper') }}</span>
            </div>              
            <div class="form-group">
                <label class="required" for="recipient">{{ trans('cruds.rrsp.fields.recipient') }}</label>
                <input class="form-control {{ $errors->has('recipient') ? 'is-invalid' : '' }}" serviceability="text" name="recipient" id="recipient" value="{{ old('recipient', $rrspHv->ics_hv->recipient) }}" readonly required>
                @if($errors->has('recipient'))
                    <span class="text-danger">{{ $errors->first('recipient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.recipient_helper') }}</span>
            </div>               
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.rrsp.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" serviceability="text" name="designation" id="designation" value="{{ old('designation', $rrspHv->ics_hv->designation) }}" readonly required>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.designation_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" serviceability="submit">
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