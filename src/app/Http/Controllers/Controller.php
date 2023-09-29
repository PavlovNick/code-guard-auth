<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\Exceptions\ExceptionLoggingTrait;
use App\Traits\Responses\JsonResponseTrait;

class Controller extends BaseController
{
    use AuthorizesRequests,
        ValidatesRequests,
        JsonResponseTrait,
        ExceptionLoggingTrait;
}
