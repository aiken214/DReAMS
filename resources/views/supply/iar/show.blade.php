@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.iar.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iar.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.id') }}
                        </th>
                        <td>
                            {{ $iar->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.date') }}
                        </th>
                        <td>
                            {{ $iar->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.iar_no') }}
                        </th>
                        <td>
                            {{ $iar->iar_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.reference') }}
                        </th>
                        <td>
                            {{ $iar->purchase_order->po_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.office') }}
                        </th>
                        <td>
                            {{ $iar->purchase_order->purchase_request->office }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.type') }}
                        </th>
                        <td>
                            {{ $iar->type }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.supplier') }}
                        </th>
                        <td>
                            {{ $iar->supplier->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.address') }}
                        </th>
                        <td>
                            {{ $iar->supplier->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.supplier.fields.tin') }}
                        </th>
                        <td>
                            {{ $iar->supplier->tin }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.invoice_no') }}
                        </th>
                        <td>
                            {{ $iar->invoice_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.invoice_date') }}
                        </th>
                        <td>
                            {{ $iar->invoice_date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar.fields.status') }}
                        </th>
                        <td>
                            {{ $iar->status }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iar.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection