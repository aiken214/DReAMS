@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rpcppe.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rpcppe.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rpcppe.fields.id') }}
                        </th>
                        <td>
                            {{ $rpcppe->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rpcppe.fields.article') }}
                        </th>
                        <td>
                            {{ $rpcppe->article }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rpcppe.fields.description') }}
                        </th>
                        <td>
                            {{ $rpcppe->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rpcppe.fields.property_no') }}
                        </th>
                        <td>
                            {{ $rpcppe->property_no }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.rpcppe.fields.unit') }}
                        </th>
                        <td>
                            {{ $rpcppe->unit }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.rpcppe.fields.unit_value') }}
                        </th>
                        <td>
                            {{ $rpcppe->unit_value }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.rpcppe.fields.quantity_property_card') }}
                        </th>
                        <td>
                            {{ $rpcppe->quantity_property_card }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rpcppe.fields.quantity_physical_count') }}
                        </th>
                        <td>
                            {{ $rpcppe->quantity_physical_count }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ __('Shortage/Overage') }} {{ trans('cruds.rpcppe.fields.quantity_so') }}
                        </th>
                        <td>
                            {{ $rpcppe->quantity_so }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ __('Shortage/Overage') }} {{ trans('cruds.rpcppe.fields.value_so') }}
                        </th>
                        <td>
                            {{ $rpcppe->value_so }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rpcppe.fields.type') }}
                        </th>
                        <td>
                            {{ $rpcppe->type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rpcppe.fields.specific_type') }}
                        </th>
                        <td>
                            {{ $rpcppe->specific_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rpcppe.fields.station') }}
                        </th>
                        <td>
                            {{ $station }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rpcppe.fields.remarks') }}
                        </th>
                        <td>
                            {{ $rpcppe->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rpcppe.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection