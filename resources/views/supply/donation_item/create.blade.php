@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.donation_item.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("supply.donation_item.store") }}" enctype="multipart/form-data" id="create_form" >
            @csrf
            <input type="text" name="donation_id" id="donation_id" value="{{ $id }}" hidden> 
            <div class="form-group row add">
                <label class="required" for="search">Select Item</label> 
                <div class="position-relative w-100 p-2">
                    <input type="text" class="select_description form-control pl-4" 
                        id="select_description" list="donation_item" name="select_description" 
                        onfocus="this.value=''" onchange="this.blur();" autocomplete="off" 
                        style="font-size:12px;">

                    <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #888;"></i>
                        <datalist id="donation_item" name="donation_item" >                              
                            @foreach($items as $item)
                                <option data-value="{{$item->description}}|{{$item->item_code}}|{{$item->unit}}" value="{{$item->description}}">
                            @endforeach                                
                        </datalist>  
                </div>            
            </div>      
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.donation_item.fields.description') }}</label>
                <textarea rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}" readonly required></textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation_item.fields.description_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="stock_no">{{ trans('cruds.donation_item.fields.stock_no') }}</label>
                <input class="form-control {{ $errors->has('stock_no') ? 'is-invalid' : '' }}" type="text" name="stock_no" id="stock_no" value="{{ old('stock_no', '') }}" readonly required>
                @if($errors->has('stock_no'))
                    <span class="text-danger">{{ $errors->first('stock_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation_item.fields.stock_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="unit">{{ trans('cruds.donation_item.fields.unit') }}</label>
                <input class="form-control {{ $errors->has('unit') ? 'is-invalid' : '' }}" type="text" name="unit" id="unit" value="{{ old('unit', '') }}" readonly required>
                @if($errors->has('unit'))
                    <span class="text-danger">{{ $errors->first('unit') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation_item.fields.unit_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.donation_item.fields.quantity') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', '') }}" required>
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation_item.fields.quantity_helper') }}</span>
            </div> 
            <div class="form-group">
                <label class="required" for="unit_price">{{ trans('cruds.donation_item.fields.unit_price') }}</label>
                <input class="form-control numbers numbers_format {{ $errors->has('unit_price') ? 'is-invalid' : '' }}" type="text" name="unit_price" id="unit_price" value="{{ old('unit_price', '') }}" required>
                @if($errors->has('unit_price'))
                    <span class="text-danger">{{ $errors->first('unit_price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation_item.fields.unit_price_helper') }}</span>
            </div>  
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.donation_item.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', '') }}" readonly required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation_item.fields.amount_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="type">{{ trans('cruds.donation_item.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', '') }}" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\IarItem::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation_item.fields.type_helper') }}</span>
            </div>      
            <div class="form-group">
                <label class="required" for="category">{{ trans('cruds.donation_item.fields.category') }}</label>
                <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" name="category" id="category" value="{{ old('category', '') }}" required>
                    <option value disabled {{ old('category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\IarItem::CATEGORY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('category', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation_item.fields.category_helper') }}</span>
            </div>    
            <div class="form-group">
                <label class="required" for="status">{{ trans('cruds.donation_item.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', '') }}" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\IarItem::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : ''}}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.donation_item.fields.status_helper') }}</span>
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
            var value2send = document.querySelector("#donation_item option[value='" + shownVal + "']").dataset.value;
            
            // Split the data from the selected option
            var parts = value2send.split('|');
            
            // Update the fields with the selected item's data
            $("textarea[name=description]").val(parts[0]);
            $("input[name=stock_no]").val(parts[1]);
            $("input[name=unit]").val(parts[2]);

           // Find the correct `unit` option by text and set it as selected
            $("select[name=unit]").find("option").each(function() {
                if ($(this).text().trim() === parts[2].trim()) {
                    $(this).prop("selected", true);
                } else {
                    $(this).prop("selected", false);
                }
            });
        });
        
        // Automatically compute the modal estimated budget input       
        $("input[name=quantity], input[name=unit_price]").change(function(){
            var amount = 0; 
            var quantity = parseFloat($("input[name=quantity]").val());
            var costInput = $("input[name=unit_price]").val().replace(/,/g, '');
            var cost = parseFloat(costInput); 

            // Calculate the budget only if both quantity and cost are valid numbers
            if (!isNaN(quantity) && !isNaN(cost)) {
                amount = quantity * cost; 
                // Keep the budget as a number, but prepare for display with fixed decimal places
                amount = amount.toFixed(2);              
            }

            // Update the budget input field, converting it to a string formatted for display
            if (!isNaN(parseFloat(amount))) {
                $("input[name=amount]").val(amount); // Set the budget directly
            } else {
                $("input[name=amount]").val('');
            }
        });
       
    }); 

</script>

@endsection
