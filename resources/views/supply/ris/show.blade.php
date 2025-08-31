@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ris.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.ris.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.id') }}
                        </th>
                        <td>
                            {{ $ris->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.date') }}
                        </th>
                        <td>
                            {{ $ris->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.ris_no') }}
                        </th>
                        <td>
                            {{ $ris->ris_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.reference') }}
                        </th>
                        <td>
                            {{ $ris->iar?->iar_no }}
                            {{ $ris->donation?->donation_no }}
                            {{ $ris->asset?->asset_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.requisitioner') }}
                        </th>
                        <td>
                            {{ $ris->purchase_request?->requested_by }}
                            {{ $ris->donation?->requester }}
                            {{ $ris->asset?->requester }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.designation') }}
                        </th>
                        <td>
                            {{ $ris->purchase_request?->designation }}
                            {{ $ris->donation?->designation }}
                            {{ $ris->asset?->designation }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.office') }}
                        </th>
                        <td>
                            {{ $ris->purchase_request?->office }}
                            {{ $ris->donation?->office }}
                            {{ $ris->asset?->office }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.recipient') }}
                        </th>
                        <td>
                            {{ $ris->recipient }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.designation') }}
                        </th>
                        <td>
                            {{ $ris->designation }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.office') }}
                        </th>
                        <td>
                            {{ $ris->office }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.ris.fields.purpose') }}
                        </th>
                        <td>
                            {{ $ris->purchase_request?->purpose }}
                            {{ $ris->donation?->purpose }}
                            {{ $ris->asset?->purpose }}
                        </td>
                    </tr>  
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.ris.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection