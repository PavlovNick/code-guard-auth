<?php

namespace Database\Seeders;

use App\Enums\Models\Roles;
use App\Models\Role;
use App\Models\User;
use App\Traits\Functions\RandomTrait;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use RandomTrait;
    protected Faker $factory;

    public function __construct(Faker $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $count = 20;

        for($i = 0; $i < $count; $i++)
        {
            $firstName = $this->factory->create()->firstName;
            $email = strtolower($firstName) . '_' . "$i" . rand(9,99) . '@' . 'gmail.com';
            $emailVerifiedAt = $this->getRandom(Carbon::now(), null);
            $firstName = $emailVerifiedAt ? $this->getRandom($firstName, null) : null;
            $lastName = $firstName ? $this->getRandom($this->factory->create()->lastName, null) : null;
            $roleId = Role::getByTitle(Roles::User->value)->id;

            $dateOfBirth = ($firstName && $emailVerifiedAt) ?
                $this->getRandom(
                    $this->generateRandomDate(60, 4, 'years'),
                    null
                ) : null;

            $password = $emailVerifiedAt ? 'admin123' : null;

            try
            {
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
            catch (\Exception $e)
            {
                $errorCode = (int)$e->getCode();
                if ($errorCode == 22007)
                {
                    $message = "\n  " . 'Error: [22007]' . "\n\n";
                    echo $message ;
                    $i--;
                    continue;
                }
            }
        }
    }
}
