@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.semi_expendable.title_singular') }} {{ trans('global.item') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.semi_expendable_lv.index') }}">
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
                            {{ $semiExpendableCard->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.stock_no') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->stock_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.description') }}
                        </th>
                        <td width="80%">
                            {{ $semiExpendableCard->description }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.unit') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->unit }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.receipt_quantity') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->receipt_quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.balance_quantity') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->balance_quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.unit_price') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->unit_price }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.total_cost') }}
                        </th>
                        <td>
                            {{ number_format((float)$semiExpendableCard->amount, 2, '.', ',') }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.type') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->type }}
                        </td>
                    </tr> 
                    @if (!empty($semiExpendableCard->iar))
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.iar_no') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->iar->iar_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.date') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->iar->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.name') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->iar->supplier->name }}
                        </td>
                    </tr>  
                    @elseif (!empty($semiExpendableCard->asset))
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.asset_no') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->asset->asset_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.date') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->asset->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.name') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->asset->supplier->name }}
                        </td>
                    </tr> 
                    @else
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.donation_no') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->donation->donation_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.date') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->donation->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.name') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->donation->supplier->name }}
                        </td>
                    </tr>      
                    @endif
                    <tr>
                        <th>
                            {{ trans('cruds.common.fields.remarks') }}
                        </th>
                        <td>
                            {{ $semiExpendableCard->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.semi_expendable_lv.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection