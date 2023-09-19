<?php

namespace Database\Seeders;

use App\Enums\Models\Roles;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $firstName = 'Admin';
        $lastName = null;
        $email = 'admin@admin.gmail';
        $roleId = Role::getByTitle(Roles::Admin->value)->id;
        $dateOfBirth = null;
        $emailVerifiedAt = Carbon::now();
        $password = 'admin123';

        User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'role_id' => $roleId,
            'date_of_birth' => $dateOfBirth,
            'email_verified_at' => $emailVerifiedAt,
            'password' => $password,
        ]);
    }
}
