@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ics_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrsp_item_hv.index2', $rrspItemHv->rrsp_hv_id) }}">
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
                            {{ $rrspItemHv->id }}
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">
                            {{ trans('cruds.ics_item.fields.description') }}
                        </th>
                        <td>
                            {{ $rrspItemHv->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $rrspItemHv->quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $rrspItemHv->unit }}
                        </td>
                    </tr> 
                    <tr> 
                        <th>
                            {{ trans('cruds.ics_item.fields.unit_cost') }}
                        </th>
                        <td>
                            {{ $rrspItemHv->unit_cost }}
                        </td>
                    </tr>
                    <tr> 
                        <th>
                            {{ trans('cruds.ics_item.fields.total_cost') }}
                        </th>
                        <td>
                            {{ $rrspItemHv->total_cost }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.inventory_no') }}
                        </th>
                        <td>
                            {{ $rrspItemHv->inventory_item_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.lifespan') }}
                        </th>
                        <td>
                            {{ $rrspItemHv->lifespan }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.serial_no') }}
                        </th>
                        <td>
                            {{ $rrspItemHv->serial_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.type') }}
                        </th>
                        <td>
                            {{ $rrspItemHv->type }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.remarks') }}
                        </th>
                        <td>
                            {{ $rrspItemHv->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrsp_item_hv.index2', $rrspItemHv->rrsp_hv_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection