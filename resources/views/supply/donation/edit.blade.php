@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.donation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.donation.update", [$donation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf            
            <div class="form-group">
                <label class="required" for="donation_no">{{ trans('cruds.donation.fields.donation_no') }}</label>
                <input class="form-control {{ $errors->has('donation_no') ? 'is-invalid' : '' }}" type="text" name="donation_no" id="donation_no" value="{{ old('donation_no', $donation->donation_no) }}" readonly required>
                @if($errors->has('donation_no'))
                    <span class="text-danger">{{ $errors->first('donation_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation.fields.donation_no_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.donation.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $donation->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation.fields.date_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="reference">{{ trans('cruds.donation.fields.reference') }}</label>
                <input class="form-control {{ $errors->has('reference') ? 'is-invalid' : '' }}" type="text" name="reference" id="reference" value="{{ old('reference', $donation->reference) }}" required>
                @if($errors->has('reference'))
                    <span class="text-danger">{{ $errors->first('reference') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation.fields.reference_helper') }}</span>
            </div>              
            <div class="form-group">
                <label class="required" for="donor">{{ trans('cruds.donation.fields.donor') }}</label>
                <input class="form-control {{ $errors->has('donor') ? 'is-invalid' : '' }}" type="text" name="donor" id="donor" value="{{ old('donor', $donation->donor) }}" required>
                @if($errors->has('donor'))
                    <span class="text-danger">{{ $errors->first('donor') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation.fields.donor_helper') }}</span>
            </div>        
            <div class="form-group">
                <label class="required" for="purpose">{{ trans('cruds.donation.fields.purpose') }}</label>
                <input class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" type="text" name="purpose" id="purpose" value="{{ old('purpose', $donation->purpose) }}" required>
                @if($errors->has('purpose'))
                    <span class="text-danger">{{ $errors->first('purpose') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation.fields.purpose_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="requester">{{ trans('cruds.donation.fields.requester') }}</label>
                <select class="unit form-control {{ $errors->has('requester') ? 'is-invalid' : '' }}" name="requester" id="requester" required>
                    <!-- Show current requester as the default selected value -->
                    <option value="{{ $donation->requester }}" selected>
                        {{ $donation->requester }}
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
                <span class="help-block">{{ trans('cruds.donation.fields.requester_helper') }}</span>
            </div>           
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.donation.fields.designation') }}</label>
                <select class="unit form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="designation" id="designation" required>
                    <option value="{{ $donation->designation }}" selected>
                        {{ $donation->designation }}
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
                <span class="help-block">{{ trans('cruds.donation.fields.designation_helper') }}</span>
            </div>                 
            <div class="form-group">
                <label class="required" for="office">{{ trans('cruds.donation.fields.office') }}</label>
                <select class="unit form-control {{ $errors->has('office') ? 'is-invalid' : '' }}" name="office" id="office" required>
                    <option value="{{ $donation->office }}" selected>
                        {{ $donation->office }}
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
                <span class="help-block">{{ trans('cruds.donation.fields.office_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="supplier_id">{{ trans('cruds.donation.fields.supplier') }}</label>
                <select class="form-control {{ $errors->has('supplier_id') ? 'is-invalid' : '' }}" name="supplier_id" id="supplier_id" required>
                    <option value disabled {{ old('supplier_id', $donation->supplier_id) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $donation->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('supplier_id'))
                    <span class="text-danger">{{ $errors->first('supplier_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation.fields.supplier_helper') }}</span>
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