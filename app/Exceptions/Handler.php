<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\ResponseStatusEnum;
use App\Http\Responses\ApiErrorResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\MultipleRecordsFoundException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Exceptions\BackedEnumCaseNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     * A list of the internal exception types that should not be reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $internalDontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        BackedEnumCaseNotFoundException::class,
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        MultipleRecordsFoundException::class,
        RecordsNotFoundException::class,
        SuspiciousOperationException::class,
        TokenMismatchException::class,
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
                'Something went wrong'
            );
        }

        return new ApiErrorResponse(
            ResponseStatusEnum::ERROR->value,
            empty($e->getCode()) ? Response::HTTP_BAD_REQUEST : $e->getCode(),
            $e->getMessage()
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
