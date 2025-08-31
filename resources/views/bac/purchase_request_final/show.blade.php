@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchase_request.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('budget.purchase_request_verify.index') }}">
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
                            {{ $purchaseRequests->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.date') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.pr_no') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->pr_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.purpose') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->purpose }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.requester') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->requested_by }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.designation') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->designation }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.office') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->office }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.res_code') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->res_code }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.fund_cluster') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->fund_cluster }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.fund_source') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->fund_source }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.finalized') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->finalized }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.checked') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->checked }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.verified') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->verified }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.approved') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->approved }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase_request.fields.remarks') }}
                        </th>
                        <td>
                            {{ $purchaseRequests->remarks }}
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('budget.purchase_request_verify.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection