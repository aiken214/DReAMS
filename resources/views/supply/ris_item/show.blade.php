@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ris_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.ris_item.index2', $risItem->ris_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ris_item.fields.id') }}
                        </th>
                        <td>
                            {{ $risItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ris_item.fields.stock_no') }}
                        </th>
                        <td>
                            {{ $risItem->stock_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ris_item.fields.description') }}
                        </th>
                        <td>
                            {{ $risItem->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ris_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $risItem->unit }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.ris_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $risItem->issued_quantity }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.ris_item.fields.available') }}
                        </th>
                        <td>
                            {{ "Yes" }}
                        </td>
                    </tr> 
                        <th>
                            {{ trans('cruds.ris_item.fields.issued_quantity') }}
                        </th>
                        <td>
                            {{ $risItem->issued_quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ris_item.fields.remarks') }}
                        </th>
                        <td>
                            {{ $risItem->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.ris_item.index2', $risItem->ris_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection