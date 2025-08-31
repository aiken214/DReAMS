<?php

namespace App\Http\Requests;

use App\Models\RisItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRisItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ris_item_edit');
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
            'category' => [
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
            'semi_expendable_card_id' => [
                'string',
            ],
        ];
    }
}
