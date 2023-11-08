<?php

namespace App\Operations;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait RespondWithJsonErrorTraitOperation
{
    protected function respondWithJsonError(
        Exception $e,
        array $headers = [],
        int $options = 0
    ): JsonResponse
    {
        $code = $e->getCode() ?? Response::HTTP_BAD_REQUEST;
        $message = $e->getMessage() ?? 'An error occurred!';
        $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        $content = [
            'message' => $message,
            'errors' => [
                'code' => $code,
            ],
        ];

        return response()->json($content, $status, $headers, $options);
    }
}
