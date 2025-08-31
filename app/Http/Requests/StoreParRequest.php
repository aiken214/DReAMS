<?php

namespace App\Http\Requests;

use App\Models\Par;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreParRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('par_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'par_no' => [
                'string',
            ],
            'entity_name' => [
                'required',
                'string',
            ],
            'recipient' => [
                'required',
                'string',
            ],
            'designation' => [
                'string',
                'required',
            ],
            'fund_cluster' => [
                'string',
                'required',
            ],
        ];
    }
}
