<?php

namespace Database\Seeders;

use App\Enums\Models\Roles;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = Roles::toArray();

        $existingRoles = Role::whereIn('title', $roles)
            ->pluck('title')
            ->toArray();

        $rolesToAdd = collect($roles)->reject(function ($role) use ($existingRoles) {
            return in_array($role, $existingRoles);
        });

        $rolesToAdd->each(function ($role) {
            $this->createRole($role);
        });
    }

    /**
     * Creates a new role.
     *
     * @param string $role title for the role
     * @return void
     */
    private function createRole(string $role)
    {
        Role::create([
            'title' => $role
        ]);
    }
}
