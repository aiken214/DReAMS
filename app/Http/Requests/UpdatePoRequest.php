<?php

namespace App\Http\Requests;

use App\Models\PurchaseOrder;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_order_edit');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'po_no' => [
                'string',
            ],
            'delivery_place' => [
                'string',
                'required',
            ],
            'delivery_date' => [
                'string',
            ],
            'delivery_term' => [
                'string',
                'required',
            ],
            'payment_term' => [
                'string',
                'required',
            ],
            'mode' => [
                'string',
                'required',
            ],
        ];
    }
}
