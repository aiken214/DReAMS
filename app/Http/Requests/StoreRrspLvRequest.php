<?php

namespace App\Http\Requests;

use App\Models\RrspLv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRrspLvRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rrsp_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'rrsp_lv_no' => [
                'string',
            ],
            'reference' => [
                'required',
                'string',
            ],
        ];
    }
}
