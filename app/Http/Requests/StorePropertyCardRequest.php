<?php

namespace App\Http\Requests;

use App\Models\PropertyCard;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePropertyCardRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('property_card_create');
    }

    public function rules()
    {
        return [
            'stock_no' => [
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
            'category' => [
                'string',
                'required',
            ],
            'status' => [
                'string',
                'required',
            ],
            'unit' => [
                'string',
                'required',
            ],
            'unit_price' => [
                'string',
                'required',
            ],
        ];
    }
}
