<?php

namespace App\Http\Requests;

use App\Models\PurchaseRequest;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePrRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_request_edit');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'pr_no' => [
                'string',
            ],
            'res_code' => [
                'string',
                'required',
            ],
            'fund_cluster' => [
                'string',
                'required',
            ],
            'purpose' => [
                'string',
                'required',
            ],
            'remarks' => [
                'string',
            ],
        ];
    }
}
