@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchase_request_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('user.purchase_request_item.index', $purchase_request_item->purchase_request_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.id') }}
                        </th>
                        <td>
                            {{ $purchase_request_item->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.stock_no') }}
                        </th>
                        <td>
                            {{ $purchase_request_item->stock_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.description') }}
                        </th>
                        <td>
                            {{ $purchase_request_item->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $purchase_request_item->unit }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $purchase_request_item->quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.unit_price') }}
                        </th>
                        <td>
                            {{ number_format((float)$purchase_request_item->unit_price, 2, '.', ',') }}    
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request_item.fields.total_cost') }}
                        </th>
                        <td>
                            {{ number_format((float)$purchase_request_item->total_cost, 2, '.', ',') }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('user.purchase_request_item.index', $purchase_request_item->purchase_request_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection