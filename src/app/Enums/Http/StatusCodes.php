<?php

namespace App\Enums\Http;

use App\Traits\Enums\EnumToArrayConverterTrait;

enum StatusCodes: int
{
    use EnumToArrayConverterTrait;

    case HTTP_OK = 200;
    case HTTP_UNAUTHORIZED = 401;
    case HTTP_FORBIDDEN = 403;
    case HTTP_NOT_FOUND = 404;
    case HTTP_UNPROCESSABLE_ENTITY = 422;
    case HTTP_INTERNAL_SERVER_ERROR = 500;
}
