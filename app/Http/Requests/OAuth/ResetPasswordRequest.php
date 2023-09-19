<?php

namespace App\Http\Requests\OAuth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'     => ['required', 'email', 'exists:users,email'],
            'code'      => ['required', 'string', 'digits:4'],
            'password'  => ['required', 'string','min:8', 'max:32'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'The E-mail field is required.',
            'email.email'       => 'The E-mail field does not match the email address standard.',
            'email.exists'      => 'The specified E-mail is not valid.',

            'code.required'     => 'The code field if required.',
            'code.digits'       => 'The code consists of 4 digits.',

            'password.required' => 'The password field is required.',
            'password.min'      => 'The minimum password length must be at least 8 characters.',
            'password.max'      => 'The maximum password length should be no more than 32 characters.',
        ];
    }
}
