@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.asset.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.asset.update", [$asset->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf            
            <div class="form-group">
                <label class="required" for="asset_no">{{ trans('cruds.asset.fields.asset_no') }}</label>
                <input class="form-control {{ $errors->has('asset_no') ? 'is-invalid' : '' }}" type="text" name="asset_no" id="asset_no" value="{{ old('asset_no', $asset->asset_no) }}" readonly required>
                @if($errors->has('asset_no'))
                    <span class="text-danger">{{ $errors->first('asset_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.asset_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.asset.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $asset->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.date_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="reference">{{ trans('cruds.asset.fields.reference') }}</label>
                <input class="form-control {{ $errors->has('reference') ? 'is-invalid' : '' }}" type="text" name="reference" id="reference" value="{{ old('reference', $asset->reference) }}" required>
                @if($errors->has('reference'))
                    <span class="text-danger">{{ $errors->first('reference') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.reference_helper') }}</span>
            </div>              
            <div class="form-group">
                <label class="required" for="invoice_no">{{ trans('cruds.asset.fields.invoice_no') }}</label>
                <input class="form-control {{ $errors->has('invoice_no') ? 'is-invalid' : '' }}" type="text" name="invoice_no" id="invoice_no" value="{{ old('invoice_no', $asset->invoice_no) }}" required>
                @if($errors->has('invoice_no'))
                    <span class="text-danger">{{ $errors->first('invoice_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.invoice_no_helper') }}</span>
            </div>          
            <div class="form-group">
                <label class="required" for="invoice_date">{{ trans('cruds.asset.fields.invoice_date') }}</label>
                <input class="form-control date {{ $errors->has('invoice_date') ? 'is-invalid' : '' }}" type="text" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', $asset->invoice_date) }}" required>
                @if($errors->has('invoice_date'))
                    <span class="text-danger">{{ $errors->first('invoice_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.invoice_date_helper') }}</span>
            </div>              
            <div class="form-group">
                <label class="required" for="purpose">{{ trans('cruds.asset.fields.purpose') }}</label>
                <input class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" type="text" name="purpose" id="purpose" value="{{ old('purpose', $asset->purpose) }}" required>
                @if($errors->has('purpose'))
                    <span class="text-danger">{{ $errors->first('purpose') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.purpose_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="requester">{{ trans('cruds.asset.fields.requester') }}</label>
                <select class="unit form-control {{ $errors->has('requester') ? 'is-invalid' : '' }}" name="requester" id="requester" required>
                    <!-- Show current requester as the default selected value -->
                    <option value="{{ $asset->requester }}" selected>
                        {{ $asset->requester }}
                    </option>

                    <!-- Show all employees as selectable options -->
                    @foreach($employees as $employee)
                        <option value="{{ $employee->fullname }}" {{ old('requester') == $employee->fullname ? 'selected' : '' }}>
                            {{ $employee->fullname }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('requester'))
                    <span class="text-danger">{{ $errors->first('requester') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.requester_helper') }}</span>
            </div>           
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.asset.fields.designation') }}</label>
                <select class="unit form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="designation" id="designation" required>
                    <option value="{{ $asset->designation }}" selected>
                        {{ $asset->designation }}
                    </option>
                    @foreach($designations as $designation)
                        <option value="{{ $designation->position }}" {{ old('designation') == $designation->position ? 'selected' : '' }}>
                            {{ $designation->position }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.designation_helper') }}</span>
            </div>                 
            <div class="form-group">
                <label class="required" for="office">{{ trans('cruds.asset.fields.office') }}</label>
                <select class="unit form-control {{ $errors->has('office') ? 'is-invalid' : '' }}" name="office" id="office" required>
                    <option value="{{ $asset->office }}" selected>
                        {{ $asset->office }}
                    </option>
                    @foreach($stations as $station)
                        <option value="{{ $station->station_name }}" {{ old('station') == $station->station_name ? 'selected' : '' }}>
                            {{ $station->station_name }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('office'))
                    <span class="text-danger">{{ $errors->first('office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.office_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="supplier_id">{{ trans('cruds.asset.fields.supplier') }}</label>
                <select class="form-control {{ $errors->has('supplier_id') ? 'is-invalid' : '' }}" name="supplier_id" id="supplier_id" required>
                    <option value disabled {{ old('supplier_id', $asset->supplier_id) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $asset->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('supplier_id'))
                    <span class="text-danger">{{ $errors->first('supplier_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.supplier_helper') }}</span>
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