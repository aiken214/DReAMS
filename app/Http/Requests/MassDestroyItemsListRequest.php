<?php

namespace App\Http\Requests;

use App\Models\ItemsList;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyItemsListRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('items_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:items_lists,id',
        ];
    }
}
