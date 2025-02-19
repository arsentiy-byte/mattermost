<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    final public function defaultResponse(string $message, mixed $data = '', int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    final public function response(mixed $data = '', int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $code);
    }

    final public function jsonApiErrorResponse(array $errors, int $code = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        return response()->json([
            'errors' => $errors,
        ], $code);
    }

    final public function errorResponse(string $message, int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }
}
