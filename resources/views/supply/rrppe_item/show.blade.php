@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.par_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrppe_item.index2', $rrppeItem->rrppe_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.id') }}
                        </th>
                        <td>
                            {{ $rrppeItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">
                            {{ trans('cruds.par_item.fields.description') }}
                        </th>
                        <td>
                            {{ $rrppeItem->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $rrppeItem->quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $rrppeItem->unit }}
                        </td>
                    </tr> 
                    <tr> 
                        <th>
                            {{ trans('cruds.par_item.fields.amount') }}
                        </th>
                        <td>
                            {{ $rrppeItem->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.property_no') }}
                        </th>
                        <td>
                            {{ $rrppeItem->property_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.date_acquired') }}
                        </th>
                        <td>
                            {{ $rrppeItem->date_acquired }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.serial_no') }}
                        </th>
                        <td>
                            {{ $rrppeItem->serial_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.type') }}
                        </th>
                        <td>
                            {{ $rrppeItem->type }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.specific_type') }}
                        </th>
                        <td>
                            {{ $rrppeItem->specific_type }}
                        </td>
                    </tr>   
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.serviceability') }}
                        </th>
                        <td>
                            {{ $rrppeItem->serviceability }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.status') }}
                        </th>
                        <td>
                            {{ $rrppeItem->status }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.remarks') }}
                        </th>
                        <td>
                            {{ $rrppeItem->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrppe_item.index2', $rrppeItem->rrppe_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection