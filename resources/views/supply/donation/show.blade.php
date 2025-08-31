@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.donation.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.donation.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.id') }}
                        </th>
                        <td>
                            {{ $donation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.date') }}
                        </th>
                        <td>
                            {{ $donation->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.donation_no') }}
                        </th>
                        <td>
                            {{ $donation->donation_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.reference') }}
                        </th>
                        <td>
                            {{ $donation->reference }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.donor') }}
                        </th>
                        <td>
                            {{ $donation->donor }}
                        </td>
                    </tr>   
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.requester') }}
                        </th>
                        <td>
                            {{ $donation->requester }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.designation') }}
                        </th>
                        <td>
                            {{ $donation->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.office') }}
                        </th>
                        <td>
                            {{ $donation->office }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.purpose') }}
                        </th>
                        <td>
                            {{ $donation->purpose }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.donation.fields.supplier') }}
                        </th>
                        <td>
                            {{ $donation->supplier->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.donation.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection