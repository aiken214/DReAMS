@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchase_order_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.purchase_order_item.index2', $purchaseOrderItem->purchase_order_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.id') }}
                        </th>
                        <td>
                            {{ $purchaseOrderItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.stock_no') }}
                        </th>
                        <td>
                            {{ $purchaseOrderItem->stock_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.description') }}
                        </th>
                        <td>
                            {{ $purchaseOrderItem->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $purchaseOrderItem->unit }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $purchaseOrderItem->quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.unit_cost') }}
                        </th>
                        <td>
                            {{ number_format((float)$purchaseOrderItem->unit_cost, 2, '.', ',') }}    
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order_item.fields.amount') }}
                        </th>
                        <td>
                            {{ number_format((float)$purchaseOrderItem->amount, 2, '.', ',') }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.purchase_order_item.index', $purchaseOrderItem->purchase_order_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection