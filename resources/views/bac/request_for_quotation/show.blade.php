@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.request_for_quotation.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.request_for_quotation.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.id') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.date') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.rfq_no') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->rfq_no }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.reference') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->purchase_request->pr_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.purpose') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->purchase_request->purpose }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.requester') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->purchase_request->requested_by }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.designation') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->purchase_request->designation }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.station') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->purchase_request->office }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.delivery_term') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->delivery_term }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.requirement') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->requirement }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.request_for_quotation.fields.status') }}
                        </th>
                        <td>
                            {{ $requestForQuotation->status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('bac.request_for_quotation.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection