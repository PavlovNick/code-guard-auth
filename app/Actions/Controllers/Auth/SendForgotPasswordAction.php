<?php

namespace App\Actions\Controllers\Auth;

use App\Actions\Models\VerificationCode\VerificationCodeAction;
use App\Mail\VerificationCodePasswordMail;
use App\Jobs\SendUsersEmailJob;
use App\Models\User;

class SendForgotPasswordAction
{
    public function handle(string $email): bool
    {

        $user = User::whereEmail($email);

        $user->validVerificationCode()?->revoke()->save();

        $code = VerificationCodeAction::create($user);

        $mail = new VerificationCodePasswordMail($user, $code->body());

        SendUsersEmailJob::dispatch($user, $mail)->onQueue('email');

        return true;

    }
}
