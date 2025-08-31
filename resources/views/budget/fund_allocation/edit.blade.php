@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.fund.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("budget.fund_allocation.update", [$fundAllocation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.fund.fields.name') }}</label>
                <select class="user_id form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    <option value="{{ $fundAllocation->user_id }}" selected>
                        {{ $fundAllocation->name }}
                    </option>
                    @foreach($users as $user)
                        @if($user->id != $fundAllocation->user_id)
                            <option value="{{ $user->id }}">
                                {{ $user->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <span class="text-danger">{{ $errors->first('user_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.name_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="fund_source">{{ trans('cruds.fund.fields.fund_source') }}</label>
                <select class="form-control {{ $errors->has('fund_source') ? 'is-invalid' : '' }}" type="text" name="fund_source" id="fund_source" value="{{ old('fund_source', $fundAllocation->fund_source) }}" required>
                    <option value disabled {{ old('fund_source', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\FundAllocation::FUND_SOURCE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('fund_source', $fundAllocation->fund_source) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('fund_source'))
                    <span class="text-danger">{{ $errors->first('fund_source') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.fund_source_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="allotment_class">{{ trans('cruds.fund.fields.allotment_class') }}</label>
                <select class="form-control {{ $errors->has('allotment_class') ? 'is-invalid' : '' }}" type="text" name="allotment_class" id="allotment_class" value="{{ old('allotment_class', $fundAllocation->allotment_class) }}" required>
                    <option value disabled {{ old('allotment_class', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\FundAllocation::ALLOTMENT_CLASS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('allotment_class', $fundAllocation->allotment_class) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('allotment_class'))
                    <span class="text-danger">{{ $errors->first('allotment_class') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.allotment_class_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="legal_basis">{{ trans('cruds.fund.fields.legal_basis') }}</label>
                <input class="form-control {{ $errors->has('legal_basis') ? 'is-invalid' : '' }}" type="text" name="legal_basis" id="legal_basis" value="{{ old('legal_basis', $fundAllocation->legal_basis) }}" required>
                @if($errors->has('legal_basis'))
                    <span class="text-danger">{{ $errors->first('legal_basis') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.legal_basis_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="particulars">{{ trans('cruds.fund.fields.particulars') }}</label>
                <input class="form-control {{ $errors->has('particulars') ? 'is-invalid' : '' }}" type="text" name="particulars" id="particulars" value="{{ old('particulars', $fundAllocation->particulars) }}" required>
                @if($errors->has('particulars'))
                    <span class="text-danger">{{ $errors->first('particulars') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.particulars_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="ppa">{{ trans('cruds.fund.fields.ppa') }}</label>
                <input class="form-control {{ $errors->has('ppa') ? 'is-invalid' : '' }}" type="text" name="ppa" id="ppa" value="{{ old('ppa', $fundAllocation->ppa) }}" required></input>
                @if($errors->has('ppa'))
                    <span class="text-danger">{{ $errors->first('ppa') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.ppa_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="appropriation">{{ trans('cruds.fund.fields.appropriation') }}</label>
                <select class="form-control {{ $errors->has('appropriation') ? 'is-invalid' : '' }}" type="text" name="appropriation" id="appropriation" value="{{ old('appropriation', $fundAllocation->appropriation) }}" required>
                    <option value disabled {{ old('appropriation', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\FundAllocation::APPROPRIATION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('appropriation', $fundAllocation->appropriation) === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('appropriation'))
                    <span class="text-danger">{{ $errors->first('appropriation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.appropriation_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.fund.fields.amount') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', $fundAllocation->amount) }}" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.amount_helper') }}</span>
            </div>   
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.fund.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', $fundAllocation->remarks) }}" >
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.remarks_helper') }}</span>
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