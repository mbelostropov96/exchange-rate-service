<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Coincap\CurrencyConvertController;
use App\Http\Controllers\Api\Coincap\CurrencyListController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CurrencyConversionRequest;
use App\Http\Responses\ApiSuccessResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as RequestAlias;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class BaseV1Controller extends Controller
{
    /**
     * @param CurrencyConversionRequest $request
     * @return ApiSuccessResponse
     * @throws BindingResolutionException
     */
    public function __invoke(Request $request): ApiSuccessResponse
    {
        $action = $request->get('method');

        $controller = null;
        if ($action !== null) {
            switch ($request->method()) {
                case RequestAlias::METHOD_GET:
                    $controller = match ($action) {
                        'list' => app(CurrencyListController::class),
                        'logout' => app(LogoutController::class),
                        default => null,
                    };
                    break;
                case RequestAlias::METHOD_POST:
                    $controller = match ($action) {
                        'convert' => app(CurrencyConvertController::class),
                        default => null,
                    };
                    break;
            }
        }

        if ($controller === null) {
            throw new RouteNotFoundException('Route not found');
        }

        return call_user_func($controller);
    }
}
