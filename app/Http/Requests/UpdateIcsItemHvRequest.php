<?php

namespace App\Http\Requests;

use App\Models\IcsItemHv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateIcsItemHvRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ics_edit');
    }

    public function rules()
    {
        return [
            'lifespan' => [
                'string',
                'required',
            ],
            'serial_no' => [
                'string',
                'required',
            ],
        ];
    }
}
