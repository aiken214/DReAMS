<?php

namespace App\Http\Requests;

use App\Models\IcsHv;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyIcsHvRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ics_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ics_hvs,id',
        ];
    }
}
