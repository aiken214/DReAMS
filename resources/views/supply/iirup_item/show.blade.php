@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.iirup_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iirup_item.index2', $iirupItem->iirup_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.id') }}
                        </th>
                        <td>
                            {{ $iirupItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.date_acquired') }}
                        </th>
                        <td>
                            {{ $iirupItem->date_acquired }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.particulars') }}
                        </th>
                        <td>
                            {{ $iirupItem->particulars }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.property_no') }}
                        </th>
                        <td>
                            {{ $iirupItem->property_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $iirupItem->quantity }}
                        </td>
                    </tr>
                    <tr> 
                        <th>
                            {{ trans('cruds.iirup_item.fields.unit_cost') }}
                        </th>
                        <td>
                            {{ $iirupItem->unit_cost != 0 ? number_format($iirupItem->unit_cost, 2, '.', ',') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.total_cost') }}
                        </th>
                        <td>
                            {{ $iirupItem->total_cost != 0 ? number_format($iirupItem->total_cost, 2, '.', ',') : '' }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.depreciation') }}
                        </th>
                        <td>
                            {{ $iirupItem->depreciation != 0 ? number_format($iirupItem->depreciation, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.losses') }}
                        </th>
                        <td>
                            {{ $iirupItem->losses != 0 ? number_format($iirupItem->losses, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.carrying_amount') }}
                        </th>
                        <td>
                            {{ $iirupItem->carrying_amount != 0 ? number_format($iirupItem->carrying_amount, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.remarks') }}
                        </th>
                        <td>
                            {{ $iirupItem->remarks }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.sale') }}
                        </th>
                        <td>
                            {{ $iirupItem->sale != 0 ? number_format($iirupItem->sale, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.transfer') }}
                        </th>
                        <td>
                            {{ $iirupItem->transfer != 0 ? number_format($iirupItem->transfer, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.destruction') }}
                        </th>
                        <td>
                            {{ $iirupItem->destruction != 0 ? number_format($iirupItem->destruction, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.others') }}
                        </th>
                        <td>
                            {{ $iirupItem->others != 0 ? number_format($iirupItem->others, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.total_dispose') }}
                        </th>
                        <td>
                            {{ $iirupItem->total_dispose != 0 ? number_format($iirupItem->total_dispose, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.appraised_value') }}
                        </th>
                        <td>
                            {{ $iirupItem->appraised_value != 0 ? number_format($iirupItem->appraised_value, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.or_no') }}
                        </th>
                        <td>
                            {{ $iirupItem->or_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.amount') }}
                        </th>
                        <td>
                            {{ $iirupItem->amount != 0 ? number_format($iirupItem->amount, 2, '.', ',') : '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iirup_item.index2', $iirupItem->iirup_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection