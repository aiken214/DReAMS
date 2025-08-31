<?php

namespace App\Http\Requests;

use App\Models\Ppmp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePpmpRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ppmp_create');
    }

    public function rules()
    {
        return [
            'calendar_year' => [
                'numeric',
                'required',
            ],
            'title' => [
                'string',
                'required',
            ],
            'type' => [
                'string',
                'required',
            ],
            'category' => [
                'string',
                'required',
            ],
            'budget_alloc' => [
                'numeric',
                'required',
                'min:0',
            ],
            'remarks' => [
                'string',
            ],
        ];
    }
}
