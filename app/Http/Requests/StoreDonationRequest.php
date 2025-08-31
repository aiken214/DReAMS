<?php

namespace App\Http\Requests;

use App\Models\Donation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDonationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('donation_create');
    }

    public function rules()
    {
        return [
            'date' => [
                'date',
                'required',
            ],
            'donation_no' => [
                'string',
            ],
            'reference' => [
                'string',
                'required',
            ],
            'donor' => [
                'string',
            ],
            'purpose' => [
                'string',
                'required',
            ],
            'requester' => [
                'string',
                'required',
            ],
            'designation' => [
                'string',
                'required',
            ],
            'office' => [
                'string',
                'required',
            ],
        ];
    }
}
