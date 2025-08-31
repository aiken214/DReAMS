@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.asset.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.asset.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.id') }}
                        </th>
                        <td>
                            {{ $asset->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.date') }}
                        </th>
                        <td>
                            {{ $asset->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.asset_no') }}
                        </th>
                        <td>
                            {{ $asset->asset_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.reference') }}
                        </th>
                        <td>
                            {{ $asset->reference }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.requester') }}
                        </th>
                        <td>
                            {{ $asset->requester }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.designation') }}
                        </th>
                        <td>
                            {{ $asset->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.office') }}
                        </th>
                        <td>
                            {{ $asset->office }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.purpose') }}
                        </th>
                        <td>
                            {{ $asset->purpose }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.supplier') }}
                        </th>
                        <td>
                            {{ $asset->supplier->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.invoice_no') }}
                        </th>
                        <td>
                            {{ $asset->invoice_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.invoice_date') }}
                        </th>
                        <td>
                            {{ $asset->invoice_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.asset.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection