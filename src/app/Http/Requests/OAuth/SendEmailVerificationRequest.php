<?php

namespace App\Http\Requests\OAuth;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailVerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => "The E-mail field is required.",
            'email.email'       => "The E-mail field does not match the email address standard.",
            'email.exists'      => "The specified E-mail is not valid.",
        ];
    }
}
