<?php

namespace App\Http\Requests;

use App\Models\PurchaseRequestItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPrItemRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('purchase_request_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:purchase_request_items,id',
        ];
    }
}
