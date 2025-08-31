@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rrsp.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.property.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.id') }}
                        </th>
                        <td>
                            {{ $propertyCard->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.stock_no') }}
                        </th>
                        <td>
                            {{ $propertyCard->stock_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.description') }}
                        </th>
                        <td>
                            {{ $propertyCard->description }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.unit') }}
                        </th>
                        <td>
                            {{ $propertyCard->unit }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.receipt_quantity') }}
                        </th>
                        <td>
                            {{ $propertyCard->receipt_quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.balance_quantity') }}
                        </th>
                        <td>
                            {{ $propertyCard->balance_quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.unit_price') }}
                        </th>
                        <td>
                            {{ number_format((float)$propertyCard->unit_price, 2, '.', ',') }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.total_cost') }}
                        </th>
                        <td>
                            {{ number_format((float)$propertyCard->amount, 2, '.', ',') }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.type') }}
                        </th>
                        <td>
                            {{ $propertyCard->type }}
                        </td>
                    </tr> 
                    @if (!empty($propertyCard->iar))
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.iar_no') }}
                        </th>
                        <td>
                            {{ $propertyCard->iar->iar_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.date') }}
                        </th>
                        <td>
                            {{ $propertyCard->iar->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.name') }}
                        </th>
                        <td>
                            {{ $propertyCard->iar->supplier->name }}
                        </td>
                    </tr>  
                    @elseif (!empty($propertyCard->asset))
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.asset_no') }}
                        </th>
                        <td>
                            {{ $propertyCard->asset->asset_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.date') }}
                        </th>
                        <td>
                            {{ $propertyCard->asset->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.name') }}
                        </th>
                        <td>
                            {{ $propertyCard->asset->supplier->name }}
                        </td>
                    </tr> 
                    @else
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.donation_no') }}
                        </th>
                        <td>
                            {{ $propertyCard->donation->donation_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.date') }}
                        </th>
                        <td>
                            {{ $propertyCard->donation->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.name') }}
                        </th>
                        <td>
                            {{ $propertyCard->donation->supplier->name }}
                        </td>
                    </tr>      
                    @endif
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.remarks') }}
                        </th>
                        <td>
                            {{ $propertyCard->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.property.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection