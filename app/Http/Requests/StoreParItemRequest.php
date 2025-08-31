<?php

namespace App\Http\Requests;

use App\Models\ParItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreParItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('par_item_create');
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
            'amount' => [
                'string',
                'required',
            ],
            'property_no' => [
                'string',
            ],
            'date_acquired' => [
                'string',
            ],
        ];
    }
}
