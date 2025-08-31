@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchase_request.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('user.purchase_request.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.id') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.date') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.pr_no') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->pr_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.purpose') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->purpose }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.requester') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->requested_by }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.designation') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->designation }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.office') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->office }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.res_code') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->res_code }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.fund_cluster') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->fund_cluster }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.fund_source') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->fund_source }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.finalized') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->finalized }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.checked') }} {{ '(Supply Office)' }}
                        </th>
                        <td>
                            {{ $purchaseRequest->checked }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.verified') }} {{ '(Budget Office)' }}
                        </th>
                        <td>
                            {{ $purchaseRequest->verified }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.approved') }} {{ '(SDS Office/HOPE)' }}
                        </th>
                        <td>
                            {{ $purchaseRequest->approved }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.quoted') }} {{ '(BAC)' }}
                        </th>
                        <td>
                            {{ $purchaseRequest->quoted }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.served') }} {{ '(Supply Office)' }}
                        </th>
                        <td>
                            {{ $purchaseRequest->served }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.delivered') }} {{ '(Supply Office)' }}
                        </th>
                        <td>
                            {{ $purchaseRequest->delivered }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.remarks') }}
                        </th>
                        <td>
                            {{ $purchaseRequest->remarks }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('user.purchase_request.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection