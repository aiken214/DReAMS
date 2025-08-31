@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.station.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.station.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.station.fields.id') }}
                        </th>
                        <td>
                            {{ $station->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.station.fields.station_id') }}
                        </th>
                        <td>
                            {{ $station->station_id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.station.fields.station_name') }}
                        </th>
                        <td>
                            {{ $station->station_name }}
                        </td>
                    </tr>   
                    <tr>
                        <th>
                            {{ trans('cruds.station.fields.category') }}
                        </th>
                        <td>
                            {{ $station->category }}
                        </td>
                    </tr>                                          
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.station.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection