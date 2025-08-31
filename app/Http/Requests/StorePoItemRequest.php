<?php

namespace App\Http\Requests;

use App\Models\PurchaseOrderItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePoItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_order_item_create');
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
                'string',
            ],
            'unit_cost' => [
                'string',
                'required',
            ],
            'amount' => [
                'string',
                'required',
            ],
        ];
    }
}
