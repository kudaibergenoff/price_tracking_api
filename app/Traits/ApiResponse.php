<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    public function successResponse(
        mixed $data = null,
        int $code = Response::HTTP_OK,
        mixed $message = 'Готово!'
    ): JsonResponse {
        return response()->json(
            [
                'success' => true,
                'data'    => $data,
                'message' => $message
            ],
            $code,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    public function errorResponse(
        mixed $data = null,
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        mixed $message = 'Что то пошло не так!'
    ): JsonResponse {
        return response()->json(
            [
                'success' => false,
                'data'    => $data,
                'message' => $message
            ],
            $code,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}
