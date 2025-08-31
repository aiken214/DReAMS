@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ppmp.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('user.ppmp.index') }}">
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
                            {{ $ppmp->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.calendar_year') }}
                        </th>
                        <td>
                            {{ $ppmp->calendar_year }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.title') }}
                        </th>
                        <td>
                            {{ $ppmp->title }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.type') }}
                        </th>
                        <td>
                            {{ $ppmp->type }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.category') }}
                        </th>
                        <td>
                            {{ $ppmp->category }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.requester') }}
                        </th>
                        <td>
                            {{ $ppmp->prepared_by }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.station') }}
                        </th>
                        <td>
                            {{ $ppmp->station }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.fund_source') }}
                        </th>
                        <td>
                            {{ $ppmp->fund_source }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.budget_alloc') }}
                        </th>
                        <td>
                            {{ number_format((float)$ppmp->budget_alloc, 2, '.', ',') }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.finalized') }}
                        </th>
                        <td>
                            {{ $ppmp->finalized }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.checked') }}
                        </th>
                        <td>
                            {{ $ppmp->checked }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.verified') }}
                        </th>
                        <td>
                            {{ $ppmp->verified }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.approved') }}
                        </th>
                        <td>
                            {{ $ppmp->approved }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.added') }}
                        </th>
                        <td>
                            {{ $ppmp->added }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ppmp.fields.remarks') }}
                        </th>
                        <td>
                            {{ $ppmp->remarks }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('user.ppmp.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection