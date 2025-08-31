<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAssetRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('asset_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'asset_no' => [
                'string',
            ],
            'invoice_no' => [
                'string',
                'required',
            ],
            'invoice_date' => [
                'string',
            ],
            'purpose' => [
                'string',
                'required',
            ],
            'requester' => [
                'string',
                'required',
            ],
            'designation' => [
                'string',
                'required',
            ],
            'office' => [
                'string',
                'required',
            ],
        ];
    }
}
