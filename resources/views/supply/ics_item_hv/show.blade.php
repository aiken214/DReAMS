@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <strong>{{ trans('global.show') }} {{ trans('cruds.ics_item.title_singular') }}</strong>
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.ics_item_hv.index2', $icsItemHv->ics_hv_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.id') }}
                        </th>
                        <td>
                            {{ $icsItemHv->id }}
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">
                            {{ trans('cruds.ics_item.fields.description') }}
                        </th>
                        <td>
                            {{ $icsItemHv->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $icsItemHv->quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $icsItemHv->unit }}
                        </td>
                    </tr> 
                    <tr> 
                        <th>
                            {{ trans('cruds.ics_item.fields.unit_cost') }}
                        </th>
                        <td>
                            {{ $icsItemHv->unit_cost }}
                        </td>
                    </tr>
                    <tr> 
                        <th>
                            {{ trans('cruds.ics_item.fields.total_cost') }}
                        </th>
                        <td>
                            {{ $icsItemHv->total_cost }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.inventory_no') }}
                        </th>
                        <td>
                            {{ $icsItemHv->inventory_item_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.lifespan') }}
                        </th>
                        <td>
                            {{ $icsItemHv->lifespan }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.serial_no') }}
                        </th>
                        <td>
                            {{ $icsItemHv->serial_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.type') }}
                        </th>
                        <td>
                            {{ $icsItemHv->type }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.remarks') }}
                        </th>
                        <td>
                            {{ $icsItemHv->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.ics_item_hv.index2', $icsItemHv->ics_hv_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection