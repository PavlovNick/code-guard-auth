<?php

namespace App\Actions\Controllers\Auth;

use Symfony\Component\HttpFoundation\Response as SResponse;
use App\Actions\Passport\TokenGeneratorAction;
use App\Enums\Passport\GrantTypes;

class RefreshAction
{
    public function handle(array $refreshToken): array|null
    {
        $response = TokenGeneratorAction::generateTokens($refreshToken, GrantTypes::TYPE_REFRESH);

        if($response->status() !== SResponse::HTTP_OK)
        {
            return null;
        }

        return json_decode($response->getBody(), true);
    }
}
