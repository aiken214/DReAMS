@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.app.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.app.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.app.fields.id') }}
                        </th>
                        <td>
                            {{ $app->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.app.fields.calendar_year') }}
                        </th>
                        <td>
                            {{ $app->calendar_year }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app.fields.title') }}
                        </th>
                        <td>
                            {{ $app->title }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app.fields.type') }}
                        </th>
                        <td>
                            {{ $app->type }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.app.fields.category') }}
                        </th>
                        <td>
                            {{ $app->category }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.app.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection