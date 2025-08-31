@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rrsp.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrsp_lv.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rrsp.fields.id') }}
                        </th>
                        <td>
                            {{ $rrspLv->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rrsp.fields.date') }}
                        </th>
                        <td>
                            {{ $rrspLv->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrsp.fields.ics_no') }}
                        </th>
                        <td>
                            {{ $rrspLv->rrsp_lv_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.rrsp.fields.reference') }}
                        </th>
                        <td>
                            {{ $rrspLv->reference }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrsp.fields.recipient') }}
                        </th>
                        <td>
                            {{ $rrspLv->ics_lv->recipient }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rrsp.fields.entity_name') }}
                        </th>
                        <td>
                            {{ $rrspLv->ics_lv->entity_name }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrsp.fields.designation') }}
                        </th>
                        <td>
                            {{ $rrspLv->ics_lv->designation }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.fund_cluster') }}
                        </th>
                        <td>
                            {{ $rrspLv->ics_lv->fund_cluster }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrsp.fields.status') }}
                        </th>
                        <td>
                            {{ $rrspLv->status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrsp_lv.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection