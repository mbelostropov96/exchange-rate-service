<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiErrorResponse implements Responsable
{
    /**
     * @param string $status
     * @param int $code
     * @param string $message
     */
    public function __construct(
        private readonly string $status,
        private readonly int $code = Response::HTTP_BAD_REQUEST,
        private readonly string $message = ''
    ) {}

    /**
     * @param $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'status' => $this->status,
            'code' => $this->code,
            'message' => $this->message
        ]);
    }
}
