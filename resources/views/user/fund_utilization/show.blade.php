@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fund.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('user.fund_utilization.index') }}">
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
                            {{ trans('cruds.fund.fields.purpose') }}
                        </th>
                        <td>
                            {{ $fundAllocation->purpose }}
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
                            {{ trans('cruds.fund.fields.sub_aro_no') }}
                        </th>
                        <td>
                            {{ $fundAllocation->sub_aro_no }}
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
                            {{ number_format((float)$fundAllocation->amount, 2, '.', ',') }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.obligated') }}
                        </th>
                        <td>
                            {{ number_format((float)$fundAllocation->obligated, 2, '.', ',') }}
                        </td>
                    </tr> 
                    <tr>
                        <th>
                            {{ trans('cruds.fund.fields.utilization_rate') }}
                        </th>
                        <td>
                            @php
                                $utilization_rate = ($fundAllocation->amount > 0) 
                                    ? ($fundAllocation->obligated / $fundAllocation->amount) * 100 
                                    : 0;
                            @endphp
                            {{ number_format((float)$utilization_rate, 2, '.', ',') }}%
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('user.fund_utilization.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection