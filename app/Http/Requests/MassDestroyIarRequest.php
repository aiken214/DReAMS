<?php

namespace App\Http\Requests;

use App\Models\Iar;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyIarRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('iar_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:iars,id',
        ];
    }
}
