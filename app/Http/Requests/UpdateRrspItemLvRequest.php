<?php

namespace App\Http\Requests;

use App\Models\RrspItemLv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRrspItemLvRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rrsp_item_edit');
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
