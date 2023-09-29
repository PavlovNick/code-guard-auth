<?php

namespace App\Traits\Responses;

use App\Enums\Http\StatusCodes;
use Illuminate\Http\JsonResponse;

trait JsonResponseTrait
{
    private function baseResponse(
        StatusCodes $statusCode,
        bool $success,
        string $message,
        object|array|string|int|float|null $data = null
    ): JsonResponse
    {
        if(!$data)
        {
            return response()->json(
                [
                    'success' => $success,
                    'message' => $message,
                ],
                $statusCode->value
            );
        }

        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'data' => $data,
            ],
            $statusCode->value
        );
    }

    public function httpOK(string $message, object|array|string|int|float|null $data = null): JsonResponse
    {
        return $this->baseResponse(StatusCodes::HTTP_OK, true, $message, $data);
    }

    public function httpNotFound(string $message): JsonResponse
    {
        return $this->baseResponse(StatusCodes::HTTP_NOT_FOUND, false, $message);
    }

    public function httpUnauthorized(string $message): JsonResponse
    {
        return $this->baseResponse(StatusCodes::HTTP_UNAUTHORIZED, false, $message);
    }

    public function httpForbidden(string $message): JsonResponse
    {
        return $this->baseResponse(StatusCodes::HTTP_FORBIDDEN, false, $message);
    }

    public function httpInternalServerError(string $message): JsonResponse
    {
        return $this->baseResponse(StatusCodes::HTTP_INTERNAL_SERVER_ERROR, false, $message);
    }

    public function httpUnprocessableEntity(string $message): JsonResponse
    {
        return $this->baseResponse(StatusCodes::HTTP_UNPROCESSABLE_ENTITY, false, $message);
    }
}
