<?php

namespace App\Http\Requests;

use App\Models\AppNonCse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAppNonCseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('app_non_cse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:app_non_cses,id',
        ];
    }
}
