@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.rrppe.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.rrsp_hv.update", [$rrppe->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf            
            <div class="form-group">
                <label class="required" for="rrppe_no">{{ trans('cruds.rrppe.fields.rrsp_no') }}</label>
                <input class="form-control {{ $errors->has('rrppe_no') ? 'is-invalid' : '' }}" serviceability="text" name="rrppe_no" id="rrppe_no" value="{{ old('rrppe_no', $rrppe->rrppe_no) }}" readonly required>
                @if($errors->has('rrppe_no'))
                    <span class="text-danger">{{ $errors->first('rrppe_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrppe.fields.rrsp_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.rrppe.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" serviceability="text" name="date" id="date" value="{{ old('date', $rrppe->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrppe.fields.date_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="serviceability">{{ trans('cruds.rrppe.fields.serviceability') }}</label>
                <select class="form-control {{ $errors->has('serviceability') ? 'is-invalid' : '' }}" serviceability="text" name="serviceability" id="serviceability" required>
                    <option value disabled {{ old('serviceability',  $rrppe->par->par_item->serviceability) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\RRPPE::SERVICEABILITY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('serviceability', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('serviceability'))
                    <span class="text-danger">{{ $errors->first('serviceability') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrppe.fields.serviceability_helper') }}</span>
            </div>     
            <div class="form-group">
                <label class="required" for="entity_name">{{ trans('cruds.rrppe.fields.entity_name') }}</label>
                <input class="form-control {{ $errors->has('entity_name') ? 'is-invalid' : '' }}" serviceability="text" name="entity_name" id="entity_name" value="{{ old('entity_name', $rrppe->par->entity_name) }}" readonly required>
                @if($errors->has('entity_name'))
                    <span class="text-danger">{{ $errors->first('entity_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrppe.fields.entity_name_helper') }}</span>
            </div>              
            <div class="form-group">
                <label class="required" for="recipient">{{ trans('cruds.rrppe.fields.recipient') }}</label>
                <input class="form-control {{ $errors->has('recipient') ? 'is-invalid' : '' }}" serviceability="text" name="recipient" id="recipient" value="{{ old('recipient', $rrppe->par->recipient) }}" readonly required>
                @if($errors->has('recipient'))
                    <span class="text-danger">{{ $errors->first('recipient') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrppe.fields.recipient_helper') }}</span>
            </div>               
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.rrppe.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" serviceability="text" name="designation" id="designation" value="{{ old('designation', $rrppe->par->designation) }}" readonly required>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrppe.fields.designation_helper') }}</span>
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