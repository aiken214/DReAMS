@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rrppe.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrppe.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.id') }}
                        </th>
                        <td>
                            {{ $rrppe->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.date') }}
                        </th>
                        <td>
                            {{ $rrppe->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.rrppe_no') }}
                        </th>
                        <td>
                            {{ $rrppe->rrppe_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.reference') }}
                        </th>
                        <td>
                            {{ $rrppe->reference }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.entity_name') }}
                        </th>
                        <td>
                            {{ $rrppe->par->entity_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.recipient') }}
                        </th>
                        <td>
                            {{ $rrppe->par->recipient }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.designation') }}
                        </th>
                        <td>
                            {{ $rrppe->par->designation }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.fund_cluster') }}
                        </th>
                        <td>
                            {{ $rrppe->par->fund_cluster }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.status') }}
                        </th>
                        <td>
                            {{ $rrppe->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rrppe.fields.remarks') }}
                        </th>
                        <td>
                            {{ $rrppe->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rrppe.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection