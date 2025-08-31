<?php

namespace App\Http\Requests;

use App\Models\RisItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRisItemRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ris_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ris_items,id',
        ];
    }
}
