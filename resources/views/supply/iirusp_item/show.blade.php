@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.iirusp_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iirusp_item.index2', $iiruspItem->iirusp_id) }}">
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
                            {{ $iiruspItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.date_acquired') }}
                        </th>
                        <td>
                            {{ $iiruspItem->date_acquired }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.particulars') }}
                        </th>
                        <td>
                            {{ $iiruspItem->particulars }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.semi_expendable_property_no') }}
                        </th>
                        <td>
                            {{ $iiruspItem->semi_expendable_property_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $iiruspItem->quantity }}
                        </td>
                    </tr> 
                    <tr> 
                        <th>
                            {{ trans('cruds.iirup_item.fields.unit_cost') }}
                        </th>
                        <td>
                            {{ $iiruspItem->unit_cost != 0 ? number_format($iiruspItem->unit_cost, 2, '.', ',') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.total_cost') }}
                        </th>
                        <td>
                            {{ $iiruspItem->total_cost != 0 ? number_format($iiruspItem->total_cost, 2, '.', ',') : '' }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.depreciation') }}
                        </th>
                        <td>
                            {{ $iiruspItem->depreciation != 0 ? number_format($iiruspItem->depreciation, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.losses') }}
                        </th>
                        <td>
                            {{ $iiruspItem->losses != 0 ? number_format($iiruspItem->losses, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.carrying_amount') }}
                        </th>
                        <td>
                            {{ $iiruspItem->carrying_amount != 0 ? number_format($iiruspItem->carrying_amount, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.remarks') }}
                        </th>
                        <td>
                            {{ $iiruspItem->remarks }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.sale') }}
                        </th>
                        <td>
                            {{ $iiruspItem->sale != 0 ? number_format($iiruspItem->sale, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.transfer') }}
                        </th>
                        <td>
                            {{ $iiruspItem->transfer != 0 ? number_format($iiruspItem->transfer, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.destruction') }}
                        </th>
                        <td>
                            {{ $iiruspItem->destruction != 0 ? number_format($iiruspItem->destruction, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.others') }}
                        </th>
                        <td>
                            {{ $iiruspItem->others != 0 ? number_format($iiruspItem->others, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.total_dispose') }}
                        </th>
                        <td>
                            {{ $iiruspItem->total_dispose != 0 ? number_format($iiruspItem->total_dispose, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.appraised_value') }}
                        </th>
                        <td>
                            {{ $iiruspItem->appraised_value != 0 ? number_format($iiruspItem->appraised_value, 2, '.', ',') : '' }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.or_no') }}
                        </th>
                        <td>
                            {{ $iiruspItem->or_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup_item.fields.amount') }}
                        </th>
                        <td>
                            {{ $iiruspItem->amount != 0 ? number_format($iiruspItem->amount, 2, '.', ',') : '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iirusp_item.index2', $iiruspItem->iirusp_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection