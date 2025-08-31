<?php

namespace App\Http\Requests;

use App\Models\RrspHv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRrspHvRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('rrsp_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:rrsp_hvs,id',
        ];
    }
}
