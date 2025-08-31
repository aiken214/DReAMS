@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ics_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrsp_item_lv.index2', $rrspItemLv->rrsp_lv_id) }}">
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
                            {{ $rrspItemLv->id }}
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">
                            {{ trans('cruds.ics_item.fields.description') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->unit }}
                        </td>
                    </tr> 
                    <tr> 
                        <th>
                            {{ trans('cruds.ics_item.fields.unit_cost') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->unit_cost }}
                        </td>
                    </tr>
                    <tr> 
                        <th>
                            {{ trans('cruds.ics_item.fields.total_cost') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->total_cost }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.inventory_no') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->inventory_item_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.lifespan') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->lifespan }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.serial_no') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->serial_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.type') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->type }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.rrsp.fields.serviceability') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->serviceability }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.remarks') }}
                        </th>
                        <td>
                            {{ $rrspItemLv->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrsp_item_lv.index2', $rrspItemLv->rrsp_lv_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection