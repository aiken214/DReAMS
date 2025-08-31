<?php

namespace App\Http\Requests;

use App\Models\Ris;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRisRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ris_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ris,id',
        ];
    }
}
