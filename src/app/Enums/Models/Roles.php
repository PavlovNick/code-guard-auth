<?php

namespace App\Enums\Models;

use App\Traits\Enums\EnumToArrayConverterTrait;

enum Roles: string
{
    use EnumToArrayConverterTrait;

    case Admin = 'admin';
    case User = 'default-user';
}
