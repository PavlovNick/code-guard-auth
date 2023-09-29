<?php

namespace App\Actions\Controllers\Auth;

use Symfony\Component\HttpFoundation\Response as SResponse;
use App\Actions\Passport\TokenGeneratorAction;
use App\Enums\Passport\GrantTypes;
use App\Models\User;

class LoginAction
{
    public function handle(string $email, string $password): array|null
    {
        $user = User::whereEmail($email);

        $data = [
            'username' => $email,
            'password' => $password,
        ];

        $response = TokenGeneratorAction::generateTokens($data, GrantTypes::TYPE_PASSWORD);

        if($response->status() !== SResponse::HTTP_OK)
        {
            return null;
        }

        $result = json_decode($response->getBody(), true);

        $user->refresh();

        $result['user'] = [
            'user_id' => $user->id,
            'first_name' => $user->first_name,
            'email' => $user->email,
        ];

        return $result;
    }
}
