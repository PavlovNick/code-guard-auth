<?php

namespace App\Http\Requests\OAuth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'     => ['required', 'email', 'exists:users,email'],
            'password'  => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'The E-mail field is required.',
            'email.email'       => 'The E-mail field does not match the email address standard.',
            'email.exists'      => 'The specified E-mail is not valid.',

            'password.required' => 'The password field is required.',
        ];
    }
}
