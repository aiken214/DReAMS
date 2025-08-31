<?php

namespace App\Http\Requests;

use App\Models\Iirusp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreIiruspRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('iirusp_create');
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
