<?php

namespace App\Http\Requests;

use App\Models\FundAllocation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFundRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fund_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
            ],
            'fund_source' => [
                'string',
                'required',
            ],
            'legal_basis' => [
                'string',
                'required',
            ],
            'particulars' => [
                'string',
                'required',
            ],
            'ppa' => [
                'string',
                'required',
            ],
            'appropriation' => [
                'string',
                'required',
            ],
            'amount' => [
                'numeric',
                'required',
                'min:0',
            ],
            'user_id' => [
                'numeric',
            ],
        ];
    }
}
