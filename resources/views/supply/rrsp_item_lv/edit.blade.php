@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.rrsp.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.rrsp_item_lv.update", [$rrspItemLv->id]) }}" enctype="multipart/form-data" id="create_form">
            @method('PUT')
            @csrf 
            <input type="text" name="rrsp_lv_id" id="rrsp_lv_id" value="{{ $rrspItemLv->rrsp_lv_id }}" hidden>
            <input type="text" name="ics_item_lv_id" id="ics_item_lv_id" value="{{ $rrspItemLv->ics_item_lv_id }}" hidden>
            <div class="form-group">
                <label class="required" for="description" hidden>{{ trans('cruds.ics_item.fields.description') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" readonly required>{{ $rrspItemLv->description }}"</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics_item.fields.description_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.ics_item.fields.unit') }}</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', $rrspItemLv->unit) }}" readonly required>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics_item.fields.unit_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="unit_cost">{{ trans('cruds.ics_item.fields.unit_cost') }}</label>
                <input class="form-control {{ $errors->has('unit_cost') ? 'is-invalid' : '' }}" type="text" name="unit_cost" id="unit_cost" value="{{ old('unit_cost', $rrspItemLv->unit_cost) }}" readonly required>
                @if($errors->has('unit_cost'))
                    <span class="text-danger">{{ $errors->first('unit_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics_item.fields.unit_cost_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="issued_quantity">{{ trans('cruds.ics_item.fields.issued_quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('issued_quantity') ? 'is-invalid' : '' }}" type="text" name="issued_quantity" id="issued_quantity" value="{{ old('issued_quantity', $rrspItemLv->ics_item_lv->quantity) }}" readonly required>
                @if($errors->has('issued_quantity'))
                    <span class="text-danger">{{ $errors->first('issued_quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics_item.fields.issued_quantity_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="returned_quantity">{{ trans('cruds.ics_item.fields.returned_quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('returned_quantity') ? 'is-invalid' : '' }}" type="text" name="returned_quantity" id="returned_quantity" value="{{ old('returned_quantity', $rrspItemLv->quantity) }}" required>
                @if($errors->has('returned_quantity'))
                    <span class="text-danger">{{ $errors->first('returned_quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.ics_item.fields.returned_quantity_helper') }}</span>
            </div>       
            <div class="form-group">
                <label class="required" for="serviceability">{{ trans('cruds.rrsp.fields.serviceability') }}</label>
                <select class="form-control {{ $errors->has('serviceability') ? 'is-invalid' : '' }}" name="serviceability" id="serviceability" required>
                    <option value disabled {{ $rrspItemLv->serviceability === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\RrspLv::SERVICEABILITY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('serviceability', $rrspItemLv->serviceability) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('serviceability'))
                    <span class="text-danger">{{ $errors->first('serviceability') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rrsp.fields.serviceability_helper') }}</span>
            </div>       
            <div class="form-group"> 
                <label for="errmessage" class="errmessage control-label" id="errmessage" name="errmessage" style="color:red"></label>
                <div>
                    <input type="message" class="message form-control" id="message" name="message" hidden>
                </div>
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
@parent

<script>

    //accept number only
    $('.numbers').keyup(function () { 
            this.value = this.value.replace(/[^0-9\.]/g,'');
        });  

    //automatically compare the available quantity and requested quantity
    $("input").change(function(){
        var comquantity = 0;
        var issued_quantity = parseFloat($("input[name=issued_quantity]").val());
        var returned_quantity = parseFloat($("input[name=returned_quantity]").val());
                        
        $("input[name=issued_quantity], input[name=returned_quantity]").each(function(){
            comquantity = issued_quantity - returned_quantity; 
        })            
        $("input[name=message]").val(comquantity);            
    });

    $("#create_form").submit(function(e) {
        e.preventDefault();  
        var comquantity = $('#message').val();
        if(comquantity < 0){
            $('#errmessage').text("*Returned Quantity must not exceed the Issued Quantity.");
        } else {
            $('#errmessage').text(""); // Clear error message if any
            // Allow form submission by not calling preventDefault
            this.submit();
        }          
    }); 
</script>

@endsection