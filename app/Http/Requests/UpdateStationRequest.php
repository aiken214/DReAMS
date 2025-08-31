<?php

namespace App\Http\Requests;

use App\Models\Station;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('station_edit');
    }

    public function rules()
    {
        return [
            'station_id' => [
                'string',
                'required',
            ],
            'station_name' => [
                'string',
                'required',
            ],
            'category' => [
                'string',
                'required',
            ],
            'accountable_officer' => [
                'string',
                'required',
            ],
            'position' => [
                'string',
                'required',
            ],
            'assumed_date' => [
                'string',
            ],
        ];
    }
}
