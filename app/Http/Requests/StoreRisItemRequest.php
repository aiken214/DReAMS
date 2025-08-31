<?php

namespace App\Http\Requests;

use App\Models\RisItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRisItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ris_item_create');
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
            'category' => [
                'string',
                'required',
            ],
            'unit' => [
                'string',
                'required',
            ],
            'balance_quantity' => [
                'string',
            ],
            'issued_quantity' => [
                'string',
                'required',
            ],
            'category' => [
                'string',
                'required',
            ],
        ];
    }
}
