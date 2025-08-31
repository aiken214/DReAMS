<?php

namespace App\Http\Requests;

use App\Models\StockCard;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStockCardRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('stock_card_edit');
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
