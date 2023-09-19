<?php

namespace App\Actions\Controllers\Auth;

use App\Enums\Models\Roles;
use App\Models\Role;
use App\Models\User;

class RegisterAction
{
    public function handle(array $userData): User|null
    {
        $user = User::create($userData);
        $roleId = Role::firstWhere('title', '=', Roles::User->value)?->id;
        $user->role()->associate($roleId)->save();

        return $user;
    }
}
