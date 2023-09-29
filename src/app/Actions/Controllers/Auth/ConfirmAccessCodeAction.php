<?php

namespace App\Actions\Controllers\Auth;

use App\Actions\Models\VerificationCode\VerificationCodeAction;
use App\Models\User;

class ConfirmAccessCodeAction
{
    public function handle(User $user, string $code): bool
    {
        VerificationCodeAction::ifExpiresRevoke($user);

        $verificationCode = $user->validVerificationCode();

        if($verificationCode?->body() != $code)
        {
            return false;
        };

        $verificationCode->revoke()->save();

        return true;
    }
}
