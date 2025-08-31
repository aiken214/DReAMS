<?php

namespace App\Http\Requests;

use App\Models\AppItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAppItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('app_item_create');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
            ],
            'ppmp_id' => [
                'string',
                'required',
            ],
            'enduser' => [
                'string',
                'required',
            ],
            'epa' => [
                'string',
                'required',
            ],            
            'mode' => [
                'string',
                'required',
            ],
            'amount' => [
                'string',
                'required',
            ],
            'remarks' => [
                'string',
                'required',
            ],
            'app_id' => [
                'string',
            ],
            'ppmp_id' => [
                'string',
            ],
        ];
    }
}
