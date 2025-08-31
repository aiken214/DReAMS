<?php

namespace App\Http\Requests;

use App\Models\Iirup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreIirupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('iirup_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'station' => [
                'string',
            ],
            'accountable_officer' => [
                'string',
                'required',
            ],
            'position' => [
                'required',
                'string',
            ],
            'requester' => [
                'string',
                'required',
            ],
        ];
    }
}
