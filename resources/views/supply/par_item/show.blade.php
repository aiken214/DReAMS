@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.par_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.par_item.index2', $parItem->par_id) }}">
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
                            {{ $parItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">
                            {{ trans('cruds.par_item.fields.description') }}
                        </th>
                        <td>
                            {{ $parItem->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $parItem->quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $parItem->unit }}
                        </td>
                    </tr> 
                    <tr> 
                        <th>
                            {{ trans('cruds.par_item.fields.amount') }}
                        </th>
                        <td>
                            {{ $parItem->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.property_no') }}
                        </th>
                        <td>
                            {{ $parItem->property_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.date_acquired') }}
                        </th>
                        <td>
                            {{ $parItem->date_acquired }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.serial_no') }}
                        </th>
                        <td>
                            {{ $parItem->serial_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.type') }}
                        </th>
                        <td>
                            {{ $parItem->type }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par_item.fields.specific_type') }}
                        </th>
                        <td>
                            {{ $parItem->specific_type }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.par_item.index2', $parItem->par_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection