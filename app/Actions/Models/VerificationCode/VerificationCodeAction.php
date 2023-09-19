<?php

namespace App\Actions\Models\VerificationCode;

use App\Models\User;
use App\Models\VerificationCode;

class VerificationCodeAction
{
    public static function create(User $user): VerificationCode
    {
        return VerificationCode::create([
            'user_id' => $user->id,
            'code' => VerificationCodeAction::generateCode(),
            'expires_at' => now()->addMinutes(config('passport.verification_code_lifetime.minutes_for_access')),
        ]);
    }

    public static function createAccessCode(User $user): VerificationCode
    {
        return VerificationCode::create([
            'user_id' => $user->id,
            'code' => VerificationCodeAction::generateCode(),
            'expires_at' => now()->addMinutes(config('passport.access_code_lifetime.minutes_for_access')),
        ]);
    }

    public static function ifExpiresRevoke(User $user): void
    {
        $user->verificationCodes()->where('expires_at', '<', now())->update(['revoked' => 1]);
    }

    private static function generateCode(): string
    {
        $randomString = '';
        for ($i = 0; $i < 4; $i++)
        {
            $randomString .= rand(0, 9);
        }

        return $randomString;
    }
}
