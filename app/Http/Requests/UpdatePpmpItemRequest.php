<?php

namespace App\Http\Requests;

use App\Models\PpmpItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePpmpItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ppmp_item_edit');
    }

    public function rules()
    {
        return [
            'code' => [
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
            'balance' => [
                'numeric',
            ],
            'requested' => [
                'numeric',
            ],
            'cost' => [
                'numeric',
                'required',
            ],
            'budget' => [
                'numeric',
                'required',
                'min:0',
            ],
            'mode' => [
                'string',
                'required',
            ],
            'jan' => [
                'numeric',
            ],
            'feb' => [
                'numeric',
            ],
            'mar' => [
                'numeric',
            ],
            'apr' => [
                'numeric',
            ],
            'may' => [
                'numeric',
            ],
            'jun' => [
                'numeric',
            ],
            'jul' => [
                'numeric',
            ],
            'aug' => [
                'numeric',
            ],
            'sep' => [
                'numeric',
            ],
            'oct' => [
                'numeric',
            ],
            'nov' => [
                'numeric',
            ],
            'dec' => [
                'numeric',
            ],
            'ppmp_id' => [
                'numeric',
            ],
        ];
    }
}
