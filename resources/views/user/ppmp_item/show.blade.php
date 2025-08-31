@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ppmp_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('user.ppmp_item.index', $ppmp_item->ppmp_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.id') }}
                        </th>
                        <td>
                            {{ $ppmp_item->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.code') }}
                        </th>
                        <td>
                            {{ $ppmp_item->code }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.description') }}
                        </th>
                        <td>
                            {{ $ppmp_item->description }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.unit') }}
                        </th>
                        <td>
                            {{ $ppmp_item->unit }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.quantity') }}
                        </th>
                        <td>
                            {{ $ppmp_item->quantity }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.cost') }}
                        </th>
                        <td>
                            {{ number_format((float)$ppmp_item->cost, 2, '.', ',') }}    
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.budget') }}
                        </th>
                        <td>
                            {{ number_format((float)$ppmp_item->budget, 2, '.', ',') }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp_item.fields.mode') }}
                        </th>
                        <td>
                            {{ $ppmp_item->mode }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.station') }}
                        </th>
                        <td>
                            {{ $ppmp_item->ppmp->station}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('user.ppmp_item.index', $ppmp_item->ppmp_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection