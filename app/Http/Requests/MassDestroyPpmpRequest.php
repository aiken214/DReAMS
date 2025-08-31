<?php

namespace App\Http\Requests;

use App\Models\Ppmp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPpmpRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ppmp_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ppmps,id',
        ];
    }
}
