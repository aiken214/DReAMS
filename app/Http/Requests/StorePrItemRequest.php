<?php

namespace App\Http\Requests;

use App\Models\PurchaseRequestItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePrItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_request_item_create');
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
            'unit' => [
                'string',
                'required',
            ],
            'quantity' => [
                'numeric',
                'required',
            ],
            'unit_price' => [
                'numeric',
                'required',
            ],
            'total_cost' => [
                'numeric',
                'required',
            ],
            'purchase_request_id' => [
                'numeric',
            ],
        ];
    }
}
