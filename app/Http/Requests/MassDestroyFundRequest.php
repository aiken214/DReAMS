<?php

namespace App\Http\Requests;

use App\Models\FundAllocation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFundRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('fund_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:fund_allocations,id',
        ];
    }
}
