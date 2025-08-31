<?php

namespace App\Http\Requests;

use App\Models\RrspHv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRrspHvRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rrsp_edit');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'rrsp_hv_no' => [
                'string',
            ],
            'reference' => [
                'string',
            ],
        ];
    }
}
