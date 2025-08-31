@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.iar_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iar_item.index2', $iarItem->iar_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.iar_item.fields.id') }}
                        </th>
                        <td>
                            {{ $iarItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iar_item.fields.stock_no') }}
                        </th>
                        <td>
                            {{ $iarItem->stock_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar_item.fields.description') }}
                        </th>
                        <td>
                            {{ $iarItem->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar_item.fields.type') }}
                        </th>
                        <td>
                            {{ $iarItem->type }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.iar_item.fields.category') }}
                        </th>
                        <td>
                            {{ $iarItem->category }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.iar_item.fields.status') }}
                        </th>
                        <td>
                            {{ $iarItem->status }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.iar_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $iarItem->unit }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iar_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $iarItem->quantity }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iar_item.index2', $iarItem->iar_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection