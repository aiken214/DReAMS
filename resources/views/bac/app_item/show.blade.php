@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.app_item.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.app_item.index2', $appItem->id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.id') }}
                        </th>
                        <td>
                            {{ $appItem->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.code') }}
                        </th>
                        <td>
                            {{ $appItem->code }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.ppmp') }}
                        </th>
                        <td>
                            {{ $appItem->ppmp }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.enduser') }}
                        </th>
                        <td>
                            {{ $appItem->enduser }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.epa') }}
                        </th>
                        <td>
                            {{ $appItem->epa }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.mode') }}
                        </th>
                        <td>
                            {{ $appItem->mode }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.posting') }}
                        </th>
                        <td>
                            {{ $appItem->posting }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.opening') }}
                        </th>
                        <td>
                            {{ $appItem->opening }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.noa') }}
                        </th>
                        <td>
                            {{ $appItem->noa }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.contract') }}
                        </th>
                        <td>
                            {{ $appItem->contract }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.fund_source') }}
                        </th>
                        <td>
                            {{ $appItem->fund_source }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.amount') }}
                        </th>
                        <td>
                            {{ number_format((float)$appItem->amount, 2, '.', ',') }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.mooe_budget') }}
                        </th>
                        <td>
                            {{ $appItem->mooe_budget }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.co_budget') }}
                        </th>
                        <td>
                            {{ $appItem->co_budget }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app_item.fields.remarks') }}
                        </th>
                        <td>
                            {{ $appItem->remarks }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.app_item.index2', $appItem->id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection