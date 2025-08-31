@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ics.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrsp_hv.index') }}">
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
                            {{ $rrspHv->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.date') }}
                        </th>
                        <td>
                            {{ $rrspHv->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrsp.fields.rrsp_no') }}
                        </th>
                        <td>
                            {{ $rrspHv->rrsp_hv_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.reference') }}
                        </th>
                        <td>
                            {{ $rrspHv->reference }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.entity_name') }}
                        </th>
                        <td>
                            {{ $rrspHv->ics_hv->entity_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.recipient') }}
                        </th>
                        <td>
                            {{ $rrspHv->ics_hv->recipient }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.designation') }}
                        </th>
                        <td>
                            {{ $rrspHv->ics_hv->designation }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.fund_cluster') }}
                        </th>
                        <td>
                            {{ $rrspHv->ics_hv->fund_cluster }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ics.fields.status') }}
                        </th>
                        <td>
                            {{ $rrspHv->status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrsp_hv.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection