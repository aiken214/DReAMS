<?php

namespace App\Http\Requests;

use App\Models\Signatory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSignatoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('signatory_edit');
    }

    public function rules()
    {
        return [
            'fullname' => [
                'string',
                'required',
            ],
            'position' => [
                'string',
                'required',
            ],
            'document' => [
                'string',
                'required',
            ],
            'type_goods' => [
                'string',
                'required',
            ],
            'designation' => [
                'string',
                'required',
            ],
            'role' => [
                'string',
                'required',
            ],
        ];
    }
}
