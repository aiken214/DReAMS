@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.par.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.par.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.par.fields.id') }}
                        </th>
                        <td>
                            {{ $par->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.par.fields.date') }}
                        </th>
                        <td>
                            {{ $par->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par.fields.par_no') }}
                        </th>
                        <td>
                            {{ $par->par_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.par.fields.reference') }}
                        </th>
                        <td>
                            {{ $par->ris->ris_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par.fields.entity_name') }}
                        </th>
                        <td>
                            {{ $par->entity_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.par.fields.recipient') }}
                        </th>
                        <td>
                            {{ $par->recipient }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par.fields.designation') }}
                        </th>
                        <td>
                            {{ $par->designation }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par.fields.fund_cluster') }}
                        </th>
                        <td>
                            {{ $par->fund_cluster }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.par.fields.status') }}
                        </th>
                        <td>
                            {{ $par->status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.par.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection