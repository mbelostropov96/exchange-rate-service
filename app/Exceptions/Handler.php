<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ResponseStatusEnum;
use App\Http\Responses\ApiErrorResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * @param $request
     * @param Throwable $e
     * @return ApiErrorResponse
     */
    public function render($request, Throwable $e): ApiErrorResponse
    {
        if (!$this->shouldReport($e)) {
            return new ApiErrorResponse(
                ResponseStatusEnum::ERROR->value,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                'loh'
            );
        }

        return new ApiErrorResponse(
            ResponseStatusEnum::ERROR->value,
            empty($e->getCode()) ? Response::HTTP_BAD_REQUEST : $e->getCode(),
            $e->getMessage() . $e->getTraceAsString()
        );
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
