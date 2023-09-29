<?php

namespace App\Traits\Exceptions;

use Illuminate\Support\Facades\Log;
use Exception;

trait ExceptionLoggingTrait
{
    protected function logException(Exception $exception): void
    {
        Log::error($exception->getMessage());
        Log::error($exception->getTraceAsString());
    }
}
