<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\Auth\ApiAuthenticateException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws ApiAuthenticateException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('api')->check()) {
            throw new ApiAuthenticateException('Invalid token', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
