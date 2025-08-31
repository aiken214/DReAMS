<?php

namespace App\Http\Requests;

use App\Models\IcsItemLv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateIcsItemLvRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ics_edit');
    }

    public function rules()
    {
        return [
            'inventory_item_no' => [
                'string',
                'required',
            ],
            'lifespan' => [
                'string',
                'required',
            ],
            'serial_no' => [
                'string',
            ],
        ];
    }
}
