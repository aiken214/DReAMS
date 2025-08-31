<?php

namespace App\Http\Requests;

use App\Models\RequestForQuotation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRfqRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('request_for_quotation_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'rfq_no' => [
                'string',
            ],
            'delivery_term' => [
                'string',
                'required',
            ],
            'requirement' => [
                'string',
                'required',
            ],
            'purchase_request_id' => [
                'string',
                'required',
            ],
        ];
    }
}
