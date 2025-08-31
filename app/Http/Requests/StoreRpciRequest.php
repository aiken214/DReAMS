<?php

namespace App\Http\Requests;

use App\Models\Rpci;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRpciRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rpci_create');
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
            'stock_no' => [
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
