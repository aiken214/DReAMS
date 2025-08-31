@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ppmp.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.app_cse.index2', $appCse->app_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.id') }}
                        </th>
                        <td>
                            {{ $appCse->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.calendar_year') }}
                        </th>
                        <td>
                            {{ $appCse->ppmp->calendar_year }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.title') }}
                        </th>
                        <td>
                            {{ $appCse->ppmp->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.type') }}
                        </th>
                        <td>
                            {{ $appCse->ppmp->type }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.category') }}
                        </th>
                        <td>
                            {{ $appCse->ppmp->category }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.prepared_by') }}
                        </th>
                        <td>
                            {{ $appCse->ppmp->prepared_by }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.station') }}
                        </th>
                        <td>
                            {{ $appCse->ppmp->station }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.fund_source') }}
                        </th>
                        <td>
                            {{ $appCse->ppmp->fund_source }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.budget_alloc') }}
                        </th>
                        <td>
                            {{ $appCse->ppmp->budget_alloc }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.finalized') }}
                        </th>
                        <td>
                            {{ $appCse->ppmp->finalized }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.app_cse.index2', $appCse->app_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection