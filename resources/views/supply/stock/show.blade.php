@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rrsp.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.stock.index') }}">
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
                            {{ $stockCard->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.stock_no') }}
                        </th>
                        <td>
                            {{ $stockCard->stock_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.description') }}
                        </th>
                        <td>
                            {{ $stockCard->description }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.unit') }}
                        </th>
                        <td>
                            {{ $stockCard->unit }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.receipt_quantity') }}
                        </th>
                        <td>
                            {{ $stockCard->receipt_quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.balance_quantity') }}
                        </th>
                        <td>
                            {{ $stockCard->balance_quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.unit_price') }}
                        </th>
                        <td>
                            {{ number_format((float)$stockCard->unit_price, 2, '.', ',') }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.total_cost') }}
                        </th>
                        <td>
                            {{ number_format((float)$stockCard->amount, 2, '.', ',') }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.type') }}
                        </th>
                        <td>
                            {{ $stockCard->type }}
                        </td>
                    </tr> 
                    @if (!empty($stockCard->iar))
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.iar_no') }}
                        </th>
                        <td>
                            {{ $stockCard->iar->iar_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.date') }}
                        </th>
                        <td>
                            {{ $stockCard->iar->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.name') }}
                        </th>
                        <td>
                            {{ $stockCard->iar->supplier->name }}
                        </td>
                    </tr>  
                    @elseif (!empty($stockCard->asset))
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.asset_no') }}
                        </th>
                        <td>
                            {{ $stockCard->asset->asset_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.date') }}
                        </th>
                        <td>
                            {{ $stockCard->asset->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.name') }}
                        </th>
                        <td>
                            {{ $stockCard->asset->supplier->name }}
                        </td>
                    </tr> 
                    @else
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.donation_no') }}
                        </th>
                        <td>
                            {{ $stockCard->donation->donation_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.date') }}
                        </th>
                        <td>
                            {{ $stockCard->donation->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.name') }}
                        </th>
                        <td>
                            {{ $stockCard->donation->supplier->name }}
                        </td>
                    </tr>      
                    @endif
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.remarks') }}
                        </th>
                        <td>
                            {{ $stockCard->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.stock.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection