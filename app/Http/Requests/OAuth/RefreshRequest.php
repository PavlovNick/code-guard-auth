<?php

namespace App\Http\Requests\OAuth;

use Illuminate\Foundation\Http\FormRequest;

class RefreshRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'refresh_token' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'refresh_token.required' => "This field is required.",
        ];
    }
}
