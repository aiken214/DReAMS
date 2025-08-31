<?php

namespace App\Http\Requests;

use App\Models\BlogPost;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBlogPostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('blog_post_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'required',
            ],
        ];
    }
}
