<?php

namespace App\Http\Requests\OAuth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'max:50',
                'unique:users'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => "The E-mail field is required.",
            'email.max'         => "The E-mail field should not exceed 50 characters.",
            'email.email'       => "The E-mail field does not match the email address standard.",
            'email.unique'      => "The specified E-mail is already registered.",
        ];
    }
}
