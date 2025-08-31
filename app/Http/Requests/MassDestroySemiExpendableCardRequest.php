<?php

namespace App\Http\Requests;

use App\Models\SemiExpendableCard;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySemiExpendableCardRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('semi_expendable_card_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:semi_expendable_cards,id',
        ];
    }
}
