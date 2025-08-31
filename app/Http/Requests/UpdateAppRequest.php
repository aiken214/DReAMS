<?php

namespace App\Http\Requests;

use App\Models\App;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAppRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('app_edit');
    }

    public function rules()
    {
        return [
            'calendar_year' => [
                'string',
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
        ];
    }
}
