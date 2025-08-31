@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ics_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.ics_item_lv.index2', $icsItemLv->ics_lv_id) }}">
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
                            {{ $icsItemLv->id }}
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">
                            {{ trans('cruds.ics_item.fields.description') }}
                        </th>
                        <td>
                            {{ $icsItemLv->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $icsItemLv->quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $icsItemLv->unit }}
                        </td>
                    </tr> 
                    <tr> 
                        <th>
                            {{ trans('cruds.ics_item.fields.unit_cost') }}
                        </th>
                        <td>
                            {{ $icsItemLv->unit_cost }}
                        </td>
                    </tr>
                    <tr> 
                        <th>
                            {{ trans('cruds.ics_item.fields.total_cost') }}
                        </th>
                        <td>
                            {{ $icsItemLv->total_cost }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.inventory_no') }}
                        </th>
                        <td>
                            {{ $icsItemLv->inventory_item_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.lifespan') }}
                        </th>
                        <td>
                            {{ $icsItemLv->lifespan }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.serial_no') }}
                        </th>
                        <td>
                            {{ $icsItemLv->serial_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics_item.fields.type') }}
                        </th>
                        <td>
                            {{ $icsItemLv->type }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.ics_item_lv.index2', $icsItemLv->ics_lv_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection