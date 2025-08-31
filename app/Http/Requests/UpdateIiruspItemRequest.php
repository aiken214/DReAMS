<?php

namespace App\Http\Requests;

use App\Models\IiruspItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateIiruspItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('iirusp_item_edit');
    }

    public function rules()
    {
        return [
            'date_acquired' => [
                'required',
            ],
            'particulars' => [
                'string',
                'required',
            ],
            'property_no' => [
                'string',
            ],
            'quantity' => [
                'required',
                'string',
            ],
            'unit_cost' => [
                'string',
                'required',
            ],
        ];
    }
}
