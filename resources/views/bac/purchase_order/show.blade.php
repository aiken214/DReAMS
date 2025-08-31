@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchase_order.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.purchase_order.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.id') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.date') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.po_no') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->po_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.reference') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->purchase_request->pr_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.purpose') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->purchase_request->purpose }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.mode') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->mode }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.delivery_place') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->delivery_place }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.delivery_date') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->delivery_date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.delivery_term') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->delivery_term }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.payment_term') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->payment_term }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.fund_source') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->purchase_request->fund_source }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                        {{ trans('cruds.supplier.title_singular') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->supplier->name }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.address') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->supplier->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.tin') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->supplier->tin }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.status') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->status }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_order.fields.remarks') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->remarks }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.purchase_order.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection