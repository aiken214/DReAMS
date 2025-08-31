<?php

namespace App\Http\Requests;

use App\Models\Rpcppe;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRpcppeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rpcppe_create');
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
            'station_id' => [
                'string',
            ],
            'remarks' => [
                'string',
                'required',
            ],
            'status' => [
                'string',
            ],
            'accountable_officer' => [
                'string',
            ],
            'position' => [
                'string',
            ],
        ];
    }
}
