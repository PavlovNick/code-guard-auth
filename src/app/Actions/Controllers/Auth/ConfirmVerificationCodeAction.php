<?php

namespace App\Actions\Controllers\Auth;


use App\Actions\Models\VerificationCode\VerificationCodeAction;
use App\Models\VerificationCode;
use App\Models\User;

class ConfirmVerificationCodeAction
{
    public function handle(User $user, string $code): VerificationCode|null
    {
        VerificationCodeAction::ifExpiresRevoke($user);

        $verificationCode = $user->validVerificationCode();

        if($verificationCode?->body() != $code)
        {
            return null;
        }

        $verificationCode->revoke()->save();

        return VerificationCodeAction::createAccessCode($user);
    }
}
