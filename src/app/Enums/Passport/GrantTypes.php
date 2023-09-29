<?php

namespace App\Enums\Passport;

enum GrantTypes: string
{
    case TYPE_PASSWORD = 'password';
    case TYPE_REFRESH = 'refresh_token';
}
