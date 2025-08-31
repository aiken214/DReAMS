<?php

namespace App\Http\Requests;

use App\Models\FundObligation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFundObligationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fund_obligation_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'obr_no' => [
                'string',
                'required',
            ],
            'amount' => [
                'numeric',
                'required',
                'min:0',
            ],
            'purchase_order_id' => [
                'numeric',
            ],
            'fund_id' => [
                'numeric',
            ],
        ];
    }
}
