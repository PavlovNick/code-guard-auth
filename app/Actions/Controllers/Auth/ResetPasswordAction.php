<?php

namespace App\Actions\Controllers\Auth;

use App\Actions\Models\User\UpdatePasswordAction;
use App\Mail\UpdatedPasswordMail;
use App\Jobs\SendUsersEmailJob;
use App\Models\User;

class ResetPasswordAction
{
    public function handle(User $user, string $password): void
    {
        UpdatePasswordAction::handle($user, $password);

        $mail = new UpdatedPasswordMail($user);

        SendUsersEmailJob::dispatch($user, $mail)->onQueue('email');
    }
}
