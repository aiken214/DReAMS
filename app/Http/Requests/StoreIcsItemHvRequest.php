<?php

namespace App\Http\Requests;

use App\Models\IcsItemHv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreIcsItemHvRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ics_create');
    }

    public function rules()
    {
        return [
            'quantity' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'required',
            ],
            'unit' => [
                'string',
                'required',
            ],
            'unit_cost' => [
                'string',
                'required',
            ],
            'total_cost' => [
                'string',
                'required',
            ],
            'inventory_item_no' => [
                'string',
                'required',
            ],
            'lifespan' => [
                'string',
                'required',
            ],
        ];
    }
}
