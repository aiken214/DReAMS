<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_create');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'string',
                'required',
                'unique:employees',
            ],
            'lastname' => [
                'string',
                'required',
            ],
            'firstname' => [
                'string',
                'required',
            ],
            'middlename' => [
                'string',
                'nullable',
            ],
            'ext_name' => [
                'string',
                'nullable',
            ],
            'position_id' => [
                'required',
                'integer',
            ],
            'station_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
