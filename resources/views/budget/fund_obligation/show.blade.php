@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fund_obligation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('budget.fund_obligation.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.id') }}
                        </th>
                        <td>
                            {{ $fundObligation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.date') }}
                        </th>
                        <td>
                            {{ $fundObligation->date }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.obr_no') }}
                        </th>
                        <td>
                            {{ $fundObligation->obr_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.amount') }}
                        </th>
                        <td>
                            {{ $fundObligation->amount }}
                        </td>
                    </tr>   
                    <tr>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.reference') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->po_no }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund_obligation.fields.supplier') }}
                        </th>
                        <td>
                            {{ $purchaseOrder->supplier->name }}
                        </td>
                    </tr>                                          
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('budget.fund_obligation.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection