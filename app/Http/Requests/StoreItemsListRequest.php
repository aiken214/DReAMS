<?php

namespace App\Http\Requests;

use App\Models\ItemsList;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreItemsListRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('items_list_create');
    }

    public function rules()
    {
        return [
            'item_code' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'required',
            ],
            'unit' => [
                'string',
                'required',
            ],
            'price' => [
                'numeric',
                'required',
            ],
        ];
    }
}
