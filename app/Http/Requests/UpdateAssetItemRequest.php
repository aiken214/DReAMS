<?php

namespace App\Http\Requests;

use App\Models\AssetItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAssetItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('asset_item_edit');
    }

    public function rules()
    {
        return [
            'description' => [
                'string',
                'required',
            ],
            'type' => [
                'string',
                'required',
            ],
            'category' => [
                'string',
                'required',
            ],
            'status' => [
                'string',
                'required',
            ],
        ];
    }
}
