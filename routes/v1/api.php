<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\BaseV1Controller;
use App\Http\Controllers\Api\Coincap\CurrencyConvertController;
use App\Http\Controllers\Api\Coincap\CurrencyListController;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/** @var Router $router */
$router = app('router');

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->post('register', RegisterController::class);
    $router->post('login', LoginController::class);

    $router->group(['middleware' => 'api.auth'], function () use ($router) {
        /**
         * Ловушка роутинга
         * Юзать \App\Http\Controllers\Api\BaseV1Controller для шаблона '/api/v1?method={method}'
         * Для всего остального есть ларавел. Пример: 'api/v1/currency/list'
         */
        $router->any('/', BaseV1Controller::class);

        $router->group(['prefix' => 'currency'], function () use ($router) {
            $router->get('logout', LogoutController::class);

            $router->get('list', CurrencyListController::class);
            $router->post('convert', CurrencyConvertController::class);
        });
    });
});
