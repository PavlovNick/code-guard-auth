<?php

namespace App\Actions\Passport;

use App\Enums\Passport\GrantTypes;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Support\Facades\Http;

class TokenGeneratorAction
{
    public static function generateTokens(array $data, GrantTypes $type): ClientResponse
    {
        $data = array_merge($data, TokenGeneratorAction::getClientData(), ['grant_type' => $type->value, 'scope' => '']);

        return Http::asForm()->post(config('app.url').'oauth/token', $data);
    }

    private static function getClientData(): array
    {
        return [
            'client_id' => config('passport.password_grant_client.id'),
            'client_secret' => config('passport.password_grant_client.secret'),
        ];
    }
}
