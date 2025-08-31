<?php

namespace App\Http\Requests;

use App\Models\IcsLv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateIcsLvRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ics_edit');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'ics_hv_no' => [
                'string',
            ],
            'reference' => [
                'string',
            ],
            'entity_name' => [
                'required',
                'string',
            ],
            'recipient' => [
                'required',
                'string',
            ],
            'designation' => [
                'string',
                'required',
            ],
            'fund_cluster' => [
                'string',
                'required',
            ],
        ];
    }
}
