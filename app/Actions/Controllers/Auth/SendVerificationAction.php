<?php

namespace App\Actions\Controllers\Auth;

use App\Actions\Models\VerificationCode\VerificationCodeAction;
use App\Mail\VerificationCodeEmailMail;
use App\Jobs\SendUsersEmailJob;
use App\Models\User;

class SendVerificationAction
{
    public function handle(User $user): bool
    {
        $user->validVerificationCode()?->revoke()->save();

        $code = VerificationCodeAction::create($user);

        $mail = new VerificationCodeEmailMail($user, $code->body());

        SendUsersEmailJob::dispatch($user, $mail)->onQueue('email');

        return true;
    }
}
