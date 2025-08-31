<?php

namespace App\Http\Requests;

use App\Models\Rsmi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRsmiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rsmi_edit');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'rsmi_no' => [
                'string',
            ],
            'entity_name' => [
                'string',
                'required',
            ],
            'fund_cluster' => [
                'required',
                'string',
            ],
        ];
    }
}
