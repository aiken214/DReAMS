@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ics.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.ics_lv.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.id') }}
                        </th>
                        <td>
                            {{ $icsLv->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.date') }}
                        </th>
                        <td>
                            {{ $icsLv->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.ics_no') }}
                        </th>
                        <td>
                            {{ $icsLv->ics_lv_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.reference') }}
                        </th>
                        <td>
                            {{ $icsLv->ris->ris_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.entity_name') }}
                        </th>
                        <td>
                            {{ $icsLv->entity_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.recipient') }}
                        </th>
                        <td>
                            {{ $icsLv->recipient }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.designation') }}
                        </th>
                        <td>
                            {{ $icsLv->designation }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.fund_cluster') }}
                        </th>
                        <td>
                            {{ $icsLv->fund_cluster }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.status') }}
                        </th>
                        <td>
                            {{ $icsLv->status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.ics_lv.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection