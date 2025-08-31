<?php

namespace App\Http\Requests;

use App\Models\Rrppe;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRrppeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rrppe_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'rrppe_no' => [
                'string',
            ],
            'reference' => [
                'required',
                'string',
            ],
        ];
    }
}
