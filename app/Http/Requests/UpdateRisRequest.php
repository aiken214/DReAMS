<?php

namespace App\Http\Requests;

use App\Models\Ris;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRisRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ris_edit');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'ris_no' => [
                'string',
            ],
            'recipient' => [
                'string',
                'required',
            ],
            'designation' => [
                'required',
                'string',
            ],
            'office' => [
                'string',
                'required',
            ],
        ];
    }
}
