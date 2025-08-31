<?php

namespace App\Http\Requests;

use App\Models\Iirusp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateIiruspRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('iirusp_edit');
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
                'required',
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
