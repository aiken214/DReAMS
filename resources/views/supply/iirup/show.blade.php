@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.iirup.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iirup.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.id') }}
                        </th>
                        <td>
                            {{ $iirup->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.date') }}
                        </th>
                        <td>
                            {{ $iirup->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.station') }}
                        </th>
                        <td>
                            {{ $iirup->station }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.accountable_officer') }}
                        </th>
                        <td>
                            {{ $iirup->accountable_officer }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.position') }}
                        </th>
                        <td>
                            {{ $iirup->position }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.requester') }}
                        </th>
                        <td>
                            {{ $iirup->requester }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iirup.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection