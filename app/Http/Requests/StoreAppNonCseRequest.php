<?php

namespace App\Http\Requests;

use App\Models\AppNonCse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAppNonCseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('app_non_cse_create');
    }

    public function rules()
    {
        return [
            'app_id' => [
                'string',
                'required',
            ],
            'ppmp_id' => [
                'string',
                'required',
            ],
        ];
    }
}
