<?php

namespace App\Actions\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

class LogoutAction
{
    public function handle(): bool
    {
        if(!Auth::check())
        {
            return false;
        }

        $user = Auth::user();
        $token = $user->token();
        $token->revoke();

        return true;
    }
}
