<?php

namespace App\Http\Requests;

use App\Models\Iar;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreIarRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('iar_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'iar_no' => [
                'string',
            ],
            'invoice_no' => [
                'string',
                'required',
            ],
            'invoice_date' => [
                'string',
            ],
            'type' => [
                'string',
                'required',
            ],
        ];
    }
}
