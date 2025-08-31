@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rsmi.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rsmi.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rsmi.fields.id') }}
                        </th>
                        <td>
                            {{ $rsmi?->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rsmi.fields.date') }}
                        </th>
                        <td>
                            {{ $rsmi->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rsmi.fields.rsmi_no') }}
                        </th>
                        <td>
                            {{ $rsmi->rsmi_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rsmi.fields.entity_name') }}
                        </th>
                        <td>
                            {{ $rsmi->entity_name }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rsmi.fields.fund_cluster') }}
                        </th>
                        <td>
                            {{ $rsmi->fund_cluster }}
                        </td>
                    </tr>        
                    <tr>
                        <th>
                            {{ trans('cruds.rsmi.fields.reference') }}
                        </th>
                        <td>
                            {{ $rsmi->purchase_order?->po_no }}
                            {{ $rsmi->donation?->donation_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rsmi.fields.supplier') }}
                        </th>
                        <td>
                            {{ $rsmi->purchase_order?->supplier->name }}
                            {{ $rsmi->donation?->donor }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.rsmi.fields.amount') }}
                        </th>
                        <td>
                            {{ number_format((float)$amount, 2, '.', ',') }}    
                        </td>
                    </tr>   
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('supply.rsmi.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection