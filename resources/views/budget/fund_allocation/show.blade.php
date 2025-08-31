@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fund_allocation.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('budget.fund_allocation.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.id') }}
                        </th>
                        <td>
                            {{ $fundAllocation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.name') }}
                        </th>
                        <td>
                            {{ $fundAllocation->name }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.fund_source') }}
                        </th>
                        <td>
                            {{ $fundAllocation->fund_source }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.allotment_class') }}
                        </th>
                        <td>
                            {{ $fundAllocation->allotment_class }}
                        </td>
                    </tr>   
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.legal_basis') }}
                        </th>
                        <td>
                            {{ $fundAllocation->legal_basis }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.particulars') }}
                        </th>
                        <td>
                            {{ $fundAllocation->particulars }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.ppa') }}
                        </th>
                        <td>
                            {{ $fundAllocation->ppa }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.appropriation') }}
                        </th>
                        <td>
                            {{ $fundAllocation->appropriation }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.amount') }}
                        </th>
                        <td>
                            {{ number_format($fundAllocation->amount, 2, '.', ',') }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.obligated') }}
                        </th>
                        <td>
                            {{ number_format($fundAllocation->obligated, 2, '.', ',') }}
                        </td>
                    </tr>  
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.unobligated') }}
                        </th>
                        <td>
                            {{ number_format($fundAllocation->unobligated, 2, '.', ',') }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.utilization_rate') }}
                        </th>
                        <td>
                            @php
                                $utilizationRate = (($fundAllocation->obligated) / $fundAllocation->amount) * 100;
                            @endphp

                            {{ number_format($utilizationRate, 2, '.', ',') }}%
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.remarks') }}
                        </th>
                        <td>
                            {{ $fundAllocation->remarks}} 
                        </td>
                    </tr> 
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('budget.fund_allocation.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection