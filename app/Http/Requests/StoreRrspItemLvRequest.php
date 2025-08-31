<?php

namespace App\Http\Requests;

use App\Models\RrspItemLv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRrspItemLvRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rrsp_item_create');
    }

    public function rules()
    {
        return [
            'description' => [
                'string',
                'required',
            ],
            'unit' => [
                'string',
                'required',
            ],
            'unit_cost' => [
                'string',
                'required',
            ],
        ];
    }
}
