<?php

namespace App\Actions\Models\User;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UpdatePasswordAction
{
    public static function handle(User $user, string $password): void
    {
        $user->update(['password' => Hash::make($password)]);
        $user->save();
    }
}
