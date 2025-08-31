<?php

namespace App\Http\Requests;

use App\Models\ParItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateParItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('par_item_create');
    }

    public function rules()
    {
        return [
            'date_acquired' => [
                'string',
            ],
            'serial_no' => [
                'string',
            ],
            'type' => [
                'string',
                'required',
            ],
            'specific_type' => [
                'string',
                'required',
            ],
        ];
    }
}
