@php
    use Carbon\Carbon;
@endphp

@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employee.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.id') }}
                        </th>
                        <td>
                            {{ $employee->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.deped_empid') }}
                        </th>
                        <td>
                            {{ $employee->emp_id }}
                        </td>
                    </tr>                    
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.lastname') }}
                        </th>
                        <td>
                            {{ $employee->lname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.firstname') }}
                        </th>
                        <td>
                            {{ $employee->fname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.middlename') }}
                        </th>
                        <td>
                            {{ $employee->mname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.ext_name') }}
                        </th>
                        <td>
                            {{ $employee->ext_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.birthdate') }}
                        </th>
                        <td>                            
                            @php
                                $dateEquivalent = is_numeric($employee->birth_date)
                                    ? Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($employee->birth_date - 1)
                                    : null;
                            @endphp

                            @if ($dateEquivalent)
                                {{ $dateEquivalent->toDateString() }}
                            @else
                                {{ $employee->birth_date }}
                            @endif
                        </td>
                    </tr>
                    
                    <tr>
                        <th>
                            {{ trans('cruds.employee.fields.position') }}
                        </th>
                        <td>
                            {{ $employee->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.station.fields.station_name') }}
                        </th>
                        <td>
                            {{ $employee->office }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection