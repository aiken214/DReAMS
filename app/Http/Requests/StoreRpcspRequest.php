<?php

namespace App\Http\Requests;

use App\Models\Rpcsp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRpcspRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rpcsp_create');
    }

    public function rules()
    {
        return [
            'article' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'required',
            ],
            'type' => [
                'string',
                'required',
            ],
            'specific_type' => [
                'string',
            ],
            'unit' => [
                'string',
                'required',
            ],
            'unit_value' => [
                'string',
                'required',
            ],
            'quantity_property_card' => [
                'string',
                'required',
            ],
            'quantity_physical_count' => [
                'string',
                'required',
            ],
            'quantity_so' => [
                'string',
            ],
            'value_so' => [
                'string',
            ],
            'remarks' => [
                'string',
                'required',
            ],
        ];
    }
}
