@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.iirup.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iirusp.index') }}">
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
                            {{ $iirusp->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.date') }}
                        </th>
                        <td>
                            {{ $iirusp->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.station') }}
                        </th>
                        <td>
                            {{ $iirusp->station }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.accountable_officer') }}
                        </th>
                        <td>
                            {{ $iirusp->accountable_officer }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.position') }}
                        </th>
                        <td>
                            {{ $iirusp->position }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.iirup.fields.requester') }}
                        </th>
                        <td>
                            {{ $iirusp->requester }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.iirusp.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection