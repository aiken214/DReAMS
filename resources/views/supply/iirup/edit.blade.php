@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.iirup.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.iirup.update", [$iirup->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf          
            <div class="form-group">
                <label class="required" for="station">{{ trans('cruds.iirup.fields.station') }}</label>
                <input class="form-control {{ $errors->has('station') ? 'is-invalid' : '' }}" type="text" name="station" id="station" value="{{ old('station', $iirup->station) }}" readonly required>
                @if($errors->has('station'))
                    <span class="text-danger">{{ $errors->first('station') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup.fields.station_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.iirup.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $iirup->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup.fields.date_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="accountable_officer">{{ trans('cruds.iirup.fields.accountable_officer') }}</label>
                <select class="accountable_officer form-control {{ $errors->has('accountable_officer') ? 'is-invalid' : '' }}" name="accountable_officer" id="accountable_officer" required>
                <option value="{{ $iirup->accountable_officer }}" selected>
                        {{ $iirup->accountable_officer }}
                    </option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->fullname }}" {{ old('accountable_officer') == $employee->fullname ? 'selected' : '' }}>
                            {{ $employee->fullname }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('accountable_officer'))
                    <span class="text-danger">{{ $errors->first('accountable_officer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup.fields.accountable_officer_helper') }}</span>
            </div>   
            <div class="form-group">
                <label class="required" for="position">{{ trans('cruds.iirup.fields.position') }}</label>
                <select class="position form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" name="position" id="position" required>
                <option value="{{ $iirup->position }}" selected>
                        {{ $iirup->position }}
                    </option>
                    @foreach($positions as $position)
                        <option value="{{ $position->position }}" {{ old('position') == $position->position ? 'selected' : '' }}>
                            {{ $position->position }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('position'))
                    <span class="text-danger">{{ $errors->first('position') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup.fields.position_helper') }}</span>
            </div>      
            <div class="form-group">
                <label class="required" for="requester">{{ trans('cruds.iirup.fields.requester') }}</label>
                <select class="requester form-control {{ $errors->has('requester') ? 'is-invalid' : '' }}" name="requester" id="requester" required>
                <option value="{{ $iirup->requester }}" selected>
                        {{ $iirup->requester }}
                    </option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->fullname }}" {{ old('requester') == $employee->fullname ? 'selected' : '' }}>
                            {{ $employee->fullname }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('requester'))
                    <span class="text-danger">{{ $errors->first('requester') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.iirup.fields.requester_helper') }}</span>
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