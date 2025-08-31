@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.ppmp.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("user.ppmp_item.update", [$ppmp_item->id]) }}" enctype="multipart/form-data" id="edit_form" >
            @method('PUT')
            @csrf
            <div class="float-left col-sm-6">  
                <div class="form-group">
                    <label class="required" for="description">{{ trans('cruds.ppmp_item.fields.description') }}</label>
                    <textarea rows="6" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description', $ppmp_item->description) }}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.ppmp_item.fields.description_helper') }}</span>
                </div>  
                <div class="form-group" style="margin-top: 30px">
                    <label class="required" for="code">{{ trans('cruds.ppmp_item.fields.code') }}</label>
                    <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $ppmp_item->code) }}" required>
                    @if($errors->has('code'))
                        <span class="text-danger">{{ $errors->first('code') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.ppmp_item.fields.code_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="unit">{{ trans('cruds.ppmp_item.fields.unit') }}</label>
                    <select class="unit form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" name="unit" id="unit" required>
                        <option value disabled {{ old('unit', $ppmp_item->unit) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->unit }}" {{ old('unit', $ppmp_item->unit) == $unit->unit ? 'selected' : '' }}>
                                {{ $unit->unit }}
                            </option>
                        @endforeach   
                    </select>
                    @if($errors->has('unit'))
                        <span class="text-danger">{{ $errors->first('unit') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.ppmp_item.fields.unit_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="quantity">{{ trans('cruds.ppmp_item.fields.quantity') }}</label>
                    <input class="form-control numbers numbers_format {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', $ppmp_item->quantity) }}" required>
                    @if($errors->has('quantity'))
                        <span class="text-danger">{{ $errors->first('quantity') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.ppmp_item.fields.quantity_helper') }}</span>
                </div> 
                <div class="form-group">
                    <label class="required" for="cost">{{ trans('cruds.ppmp_item.fields.cost') }}</label>
                    <input class="form-control numbers numbers_format {{ $errors->has('cost') ? 'is-invalid' : '' }}" type="text" name="cost" id="cost" value="{{ old('cost', $ppmp_item->cost) }}" required>
                    @if($errors->has('cost'))
                        <span class="text-danger">{{ $errors->first('cost') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.ppmp_item.fields.cost_helper') }}</span>
                </div>  
                <div class="form-group">
                    <label class="required" for="budget">{{ trans('cruds.ppmp_item.fields.budget') }}</label>
                    <input class="form-control numbers numbers_format {{ $errors->has('budget') ? 'is-invalid' : '' }}" type="text" name="budget" id="budget" value="{{ old('budget', $ppmp_item->budget) }}" readonly required>
                    @if($errors->has('budget'))
                        <span class="text-danger">{{ $errors->first('budget') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.ppmp_item.fields.budget_helper') }}</span>
                </div> 
                <div class="form-group">
                    <label class="required" for="mode">{{ trans('cruds.ppmp_item.fields.mode') }}</label>
                    <select class="form-control {{ $errors->has('mode') ? 'is-invalid' : '' }}" name="mode" id="mode" required>
                        <option value="" disabled {{ old('mode', $ppmp_item->mode) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\PpmpItem::MODE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('mode', $ppmp_item->mode) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('mode'))
                        <span class="text-danger">{{ $errors->first('mode') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.ppmp_item.fields.mode_helper') }}</span>
                </div>
            </div>
            <div class="float-right col-sm-6">
                <div class="form-group row add">
                    <label for="schedule" class="control-label col-sm-12">Schedule of Activities :</label>                            
                </div>
                <div class="float-left col-sm-6">
                    <div class="form-group">
                        <label class="required" for="jan">{{ trans('cruds.ppmp_item.fields.jan') }}</label>
                        <input class="form-control numbers numbers_format {{ $errors->has('jan') ? 'is-invalid' : '' }}" type="text" name="jan" id="jan" value="{{ old('jan', $ppmp_item->jan) }}" >
                        @if($errors->has('jan'))
                            <span class="text-danger">{{ $errors->first('jan') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.jan_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="feb">{{ trans('cruds.ppmp_item.fields.feb') }}</label>
                        <input class="form-control numbers numbers_format {{ $errors->has('feb') ? 'is-invalid' : '' }}" type="text" name="feb" id="feb" value="{{ old('feb', $ppmp_item->feb) }}" >
                        @if($errors->has('feb'))
                            <span class="text-danger">{{ $errors->first('feb') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.feb_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="mar">{{ trans('cruds.ppmp_item.fields.mar') }}</label>
                        <input class="form-control numbers numbers_format {{ $errors->has('mar') ? 'is-invalid' : '' }}" type="text" name="mar" id="mar" value="{{ old('mar', $ppmp_item->mar) }}" >
                        @if($errors->has('mar'))
                            <span class="text-danger">{{ $errors->first('mar') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.mar_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="apr">{{ trans('cruds.ppmp_item.fields.apr') }}</label>
                        <input class="form-control numbers numbers_format {{ $errors->has('apr') ? 'is-invalid' : '' }}" type="text" name="apr" id="apr" value="{{ old('apr', $ppmp_item->apr) }}" >
                        @if($errors->has('apr'))
                            <span class="text-danger">{{ $errors->first('apr') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.apr_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="may">{{ trans('cruds.ppmp_item.fields.may') }}</label>
                        <input class="form-control numbers numbers_format {{ $errors->has('may') ? 'is-invalid' : '' }}" type="text" name="may" id="may" value="{{ old('may', $ppmp_item->may) }}" >
                        @if($errors->has('may'))
                            <span class="text-danger">{{ $errors->first('may') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.may_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="jun">{{ trans('cruds.ppmp_item.fields.jun') }}</label>
                        <input class="form-control numbers numbers_format {{ $errors->has('jun') ? 'is-invalid' : '' }}" type="text" name="jun" id="jun" value="{{ old('jun', $ppmp_item->jun) }}" >
                        @if($errors->has('jun'))
                            <span class="text-danger">{{ $errors->first('jun') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.jun_helper') }}</span>
                    </div>
                </div>
                <div class="float-left col-sm-6">
                    <div class="form-group">
                        <label class="required" for="jul">{{ trans('cruds.ppmp_item.fields.jul') }}</label>
                        <input class="form-control  numbers numbers_format {{ $errors->has('jul') ? 'is-invalid' : '' }}" type="text" name="jul" id="jul" value="{{ old('jul', $ppmp_item->jul) }}" >
                        @if($errors->has('jul'))
                            <span class="text-danger">{{ $errors->first('jul') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.jul_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="aug">{{ trans('cruds.ppmp_item.fields.aug') }}</label>
                        <input class="form-control  numbers numbers_format {{ $errors->has('aug') ? 'is-invalid' : '' }}" type="text" name="aug" id="aug" value="{{ old('aug', $ppmp_item->aug) }}" >
                        @if($errors->has('aug'))
                            <span class="text-danger">{{ $errors->first('aug') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.aug_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="sep">{{ trans('cruds.ppmp_item.fields.sep') }}</label>
                        <input class="form-control  numbers numbers_format {{ $errors->has('sep') ? 'is-invalid' : '' }}" type="text" name="sep" id="sep" value="{{ old('sep', $ppmp_item->sep) }}" >
                        @if($errors->has('sep'))
                            <span class="text-danger">{{ $errors->first('sep') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.sep_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="oct">{{ trans('cruds.ppmp_item.fields.oct') }}</label>
                        <input class="form-control  numbers numbers_format {{ $errors->has('jul') ? 'is-invalid' : '' }}" type="text" name="oct" id="oct" value="{{ old('oct', $ppmp_item->oct) }}" >
                        @if($errors->has('oct'))
                            <span class="text-danger">{{ $errors->first('oct') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.oct_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="nov">{{ trans('cruds.ppmp_item.fields.nov') }}</label>
                        <input class="form-control  numbers numbers_format {{ $errors->has('nov') ? 'is-invalid' : '' }}" type="text" name="nov" id="nov" value="{{ old('nov', $ppmp_item->nov) }}" >
                        @if($errors->has('nov'))
                            <span class="text-danger">{{ $errors->first('nov') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.nov_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="dec">{{ trans('cruds.ppmp_item.fields.dec') }}</label>
                        <input class="form-control  numbers numbers_format {{ $errors->has('dec') ? 'is-invalid' : '' }}" type="text" name="dec" id="dec" value="{{ old('dec', $ppmp_item->dec) }}" >
                        @if($errors->has('dec'))
                            <span class="text-danger">{{ $errors->first('dec') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.ppmp_item.fields.dec_helper') }}</span>
                    </div>
                </div> 
                <div class="float-left col-sm-12">
                    <div class="form-group"> 
                        <label for="errmessage" class="errmessage control-label col-sm-12" id="errmessage" name="errmessage" style="color:red"></label>
                        <div class="col-sm-8">
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
                </div>               
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
            this.value = this.value.replace(/[^0-9\.]/g,'');
        }); 

        //automatically compute the modal estimated budget input       
        $("input").change(function(){
            var budget = 0; 
            var quantity = parseFloat($("input[name=quantity]").val());
            var cost = parseFloat($("input[name=cost]").val());           
            $("input[name=quantity], input[name=cost]").each(function(){                   
                budget = quantity * cost; 
                budget = budget.toFixed(2);              
            })
            if(!isNaN(parseInt(budget)))
                $("input[name=budget]").val(budget);
            else
                $("input[name=budget]").val('');
        });

        //automatically compare the modal quantity and milestone input
        $("input").change(function(){
            var comquantity = 0;
            var milestone = 0;
            var quantity = parseFloat($("input[name=quantity]").val());
            if($("input[name=jan]").val() == ''){var jan = 0; }else { var jan = parseFloat($("input[name=jan]").val()); }
            if($("input[name=feb]").val() == ''){var feb = 0; }else { var feb = parseFloat($("input[name=feb]").val()); }
            if($("input[name=mar]").val() == ''){var mar = 0; }else { var mar = parseFloat($("input[name=mar]").val()); }
            if($("input[name=apr]").val() == ''){var apr = 0; }else { var apr = parseFloat($("input[name=apr]").val()); }
            if($("input[name=may]").val() == ''){var may = 0; }else { var may = parseFloat($("input[name=may]").val()); }
            if($("input[name=jun]").val() == ''){var jun = 0; }else { var jun = parseFloat($("input[name=jun]").val()); }
            if($("input[name=jul]").val() == ''){var jul = 0; }else { var jul = parseFloat($("input[name=jul]").val()); }
            if($("input[name=aug]").val() == ''){var aug = 0; }else { var aug = parseFloat($("input[name=aug]").val()); }
            if($("input[name=sep]").val() == ''){var sep = 0; }else { var sep = parseFloat($("input[name=sep]").val()); }
            if($("input[name=oct]").val() == ''){var oct = 0; }else { var oct = parseFloat($("input[name=oct]").val()); }
            if($("input[name=nov]").val() == ''){var nov = 0; }else { var nov = parseFloat($("input[name=nov]").val()); }
            if($("input[name=dec]").val() == ''){var dec = 0; }else { var dec = parseFloat($("input[name=dec]").val()); }
            
            $("input[name=quantity], input[name=jan], input[name=feb], input[name=mar], input[name=apr], input[name=may], input[name=jun], input[name=jul], input[name=aug], input[name=sep], input[name=oct], input[name=nov], input[name=dec]").each(function(){
                milestone = jan + feb + mar + apr + may + jun + jul + aug + sep + oct + nov + dec;
                comquantity = quantity - milestone;              
            })
            $("input[name=message]").val(comquantity);            
        });

        $("#edit_form").submit(function(e) {
            e.preventDefault();  
            var comquantity = $('#message').val();
            if(comquantity != 0){
                $('#errmessage').text("*Quantity must be equal with the quantity in the Schedule of Activities.");
            } else {
                $('#errmessage').text(""); // Clear error message if any
                // Allow form submission by not calling preventDefault
                this.submit();
            }          
        }); 

    }); 

</script>

@endsection