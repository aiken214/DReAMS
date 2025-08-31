<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\DavnorsysEmployee;
use Illuminate\Support\Facades\DB; 
use App\Models\Position;
use App\Models\Station;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = DavnorsysEmployee::all();

        return view('admin.employees.index', compact('employees'));
    }

    public function getEmployees(Request $request)
    {                
        $data = DavnorsysEmployee::all()->sortBy('lname');
        
        return datatables($data)->make(true);   

    }

    public function create()
    {
        abort_if(Gate::denies('employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $positions = Position::pluck('position', 'id')->prepend(trans('global.pleaseSelect'), '');

        $stations = Station::pluck('stationcode', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employees.create', compact('positions', 'stations'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());

        return redirect()->route('admin.employees.index');
    }

    public function edit(Employee $employee)
    {
        abort_if(Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

     //   $plantillas = Plantilla::pluck('item_code', 'id')->prepend(trans('global.pleaseSelect'), '');
        $plantillas=DB::table('plantillas')
            ->leftJoin('employees', 'employees.plantilla_id', '=', 'plantillas.id')
            ->leftJoin('jobtitles', 'jobtitles.id', '=', 'plantillas.jobtitle_id')
            ->whereNull('employees.plantilla_id')
            ->select('plantillas.*', 'Jobtitles.*')
            ->get();

        $reporting_managers = ReportingManager::pluck('management_title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employee_statuses = EmployeeStatus::pluck('description', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updatedbies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assigned_stations = Station::pluck('stationcode', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employee->load('plantilla', 'reporting_manager', 'employee_status', 'createdby', 'updatedby', 'assigned_station');

        return view('admin.employees.edit', compact('assigned_stations', 'employee', 'employee_statuses', 'plantillas', 'reporting_managers', 'updatedbies'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->all());

        return redirect()->route('admin.employees.index');
    }

    public function show(Employee $employee)
    {
        abort_if(Gate::denies('employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->load('plantilla', 'reporting_manager', 'employee_status', 'createdby', 'updatedby', 'assigned_station', 'employeeReportingManagers', 'employeeServiceRecords', 'employeeHrdTrainingParticipants', 'employeeTeacherAssignments', 'employeePyrPayrollLeaves', 'employeeServiceRecordsSearches');

        return view('admin.employees.show', compact('employee'));
    }

    public function destroy(Employee $employee)
    {
        abort_if(Gate::denies('employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeRequest $request)
    {
        Employee::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
