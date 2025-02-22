<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'post.title'              => 'required|string|max:255',
            'post.description'        => 'required|string',
            'post.recruitment_target' => 'nullable|integer|min:1',
            'post.recruitment_count'  => 'nullable|integer|min:0',
        ];
    }
}
