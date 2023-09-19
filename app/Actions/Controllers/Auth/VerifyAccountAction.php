<?php

namespace App\Actions\Controllers\Auth;

use App\Actions\Models\User\UpdatePasswordAction;
use App\Mail\SuccessfulRegistrationMail;
use App\Jobs\SendUsersEmailJob;
use App\Models\User;

class VerifyAccountAction
{
    public function handle(User $user, string $password): void
    {
        UpdatePasswordAction::handle($user, $password);

        $user->markEmailAsVerified();

        $mail = new SuccessfulRegistrationMail($user);

        SendUsersEmailJob::dispatch($user, $mail)->onQueue('email');
    }
}
