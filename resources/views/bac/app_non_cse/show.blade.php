@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ppmp.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.app_non_cse.index2', $appNonCse->app_id) }}">
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
                            {{ $appNonCse->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.calendar_year') }}
                        </th>
                        <td>
                            {{ $appNonCse->ppmp->calendar_year }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.title') }}
                        </th>
                        <td>
                            {{ $appNonCse->ppmp->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.type') }}
                        </th>
                        <td>
                            {{ $appNonCse->ppmp->type }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.category') }}
                        </th>
                        <td>
                            {{ $appNonCse->ppmp->category }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.prepared_by') }}
                        </th>
                        <td>
                            {{ $appNonCse->ppmp->prepared_by }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.station') }}
                        </th>
                        <td>
                            {{ $appNonCse->ppmp->station }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.fund_source') }}
                        </th>
                        <td>
                            {{ $appNonCse->ppmp->fund_source }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.budget_alloc') }}
                        </th>
                        <td>
                            {{ $appNonCse->ppmp->budget_alloc }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.finalized') }}
                        </th>
                        <td>
                            {{ $appNonCse->ppmp->finalized }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.app_non_cse.index2', $appNonCse->app_id) }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection