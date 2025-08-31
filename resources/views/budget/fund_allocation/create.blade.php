@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.fund.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("budget.fund_allocation.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.fund.fields.name') }}</label>
                <select class="user_id form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    <option value disabled {{ old('user_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach   
                </select>
                @if($errors->has('user_id'))
                <span class="text-danger">{{ $errors->first('user_id') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.name_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="fund_source">{{ trans('cruds.fund.fields.fund_source') }}</label>
                <select class="form-control {{ $errors->has('fund_source') ? 'is-invalid' : '' }}" type="text" name="fund_source" id="fund_source" value="{{ old('fund_source', '') }}" required>
                    <option value disabled {{ old('fund_source', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\FundAllocation::FUND_SOURCE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('fund_source', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('fund_source'))
                    <span class="text-danger">{{ $errors->first('fund_source') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.fund_source_helper') }}</span>
            </div>              
            <div class="form-group">
                <label class="required" for="allotment_class">{{ trans('cruds.fund.fields.allotment_class') }}</label>
                <select class="form-control {{ $errors->has('allotment_class') ? 'is-invalid' : '' }}" type="text" name="allotment_class" id="allotment_class" value="{{ old('allotment_class', '') }}" required>
                    <option value disabled {{ old('allotment_class', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\FundAllocation::ALLOTMENT_CLASS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('allotment_class', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('allotment_class'))
                    <span class="text-danger">{{ $errors->first('allotment_class') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.allotment_class_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="legal_basis">{{ trans('cruds.fund.fields.legal_basis') }}</label>
                <input class="form-control {{ $errors->has('legal_basis') ? 'is-invalid' : '' }}" type="text" name="legal_basis" id="legal_basis" value="{{ old('legal_basis', '') }}" required>
                @if($errors->has('legal_basis'))
                    <span class="text-danger">{{ $errors->first('legal_basis') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.legal_basis_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="particulars">{{ trans('cruds.fund.fields.particulars') }}</label>
                <textarea class="form-control {{ $errors->has('particulars') ? 'is-invalid' : '' }}" type="text" name="particulars" id="particulars" value="{{ old('particulars', '') }}" required></textarea>
                @if($errors->has('particulars'))
                    <span class="text-danger">{{ $errors->first('particulars') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.particulars_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="ppa">{{ trans('cruds.fund.fields.ppa') }}</label>
                <input class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" type="text" name="ppa" id="ppa" value="{{ old('ppa', '') }}" required></input>
                @if($errors->has('ppa'))
                    <span class="text-danger">{{ $errors->first('ppa') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.ppa_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="appropriation">{{ trans('cruds.fund.fields.appropriation') }}</label>
                <select class="form-control {{ $errors->has('appropriation') ? 'is-invalid' : '' }}" type="text" name="appropriation" id="appropriation" value="{{ old('appropriation', '') }}" required>
                    <option value disabled {{ old('appropriation', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\FundAllocation::APPROPRIATION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('appropriation', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('appropriation'))
                    <span class="text-danger">{{ $errors->first('appropriation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.appropriation_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.fund.fields.amount') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', '') }}" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fund.fields.amount_helper') }}</span>
            </div>    
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.fund.fields.remarks') }}</label>
                <textarea class="form-control {{ $errors->has('particulars') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', '') }}" ></textarea>
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
    </div>
</div>
@endsection

@section('scripts')

<script>

    $(document).ready( function () {
        //accept number only
        $('.numbers').keyup(function () { 
            this.value = this.value.replace(/[^0-9.,]/g, '');
        });   
                
        // autofill with items data
        $("#select_description").change(function(){
            var shownVal = document.getElementById("select_description").value;
            var value2send = document.querySelector("#pr_item option[value='" + shownVal + "']").dataset.value;
            
            // Split the data from the selected option
            var parts = value2send.split('|');
            
            // Update the fields with the selected item's data
            $("textarea[name=description]").val(parts[0]);
            $("input[name=stock_no]").val(parts[1]);
            $("input[name=unit_price]").val(parts[3]);
            $("input[name=available_quantity]").val(parts[4]);

           // Find the correct `unit` option by text and set it as selected
            $("select[name=unit]").find("option").each(function() {
                if ($(this).text().trim() === parts[2].trim()) {
                    $(this).prop("selected", true);
                } else {
                    $(this).prop("selected", false);
                }
            });
        });
               
    }); 

</script>

@endsection