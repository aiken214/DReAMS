@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.asset_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.asset_item.index2', $assetItem->asset_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.asset_item.fields.id') }}
                        </th>
                        <td>
                            {{ $assetItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset_item.fields.stock_no') }}
                        </th>
                        <td>
                            {{ $assetItem->stock_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.asset_item.fields.description') }}
                        </th>
                        <td>
                            {{ $assetItem->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.asset_item.fields.type') }}
                        </th>
                        <td>
                            {{ $assetItem->type }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.asset_item.fields.category') }}
                        </th>
                        <td>
                            {{ $assetItem->category }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.asset_item.fields.status') }}
                        </th>
                        <td>
                            {{ $assetItem->status }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.asset_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $assetItem->unit }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.asset_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $assetItem->quantity }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.asset_item.index2', $assetItem->asset_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection