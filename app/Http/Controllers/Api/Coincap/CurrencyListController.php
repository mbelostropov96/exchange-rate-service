<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Coincap;

use App\Enums\ResponseStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiSuccessResponse;
use App\Task\CurrencyListTask;
use App\UseCase\CurrencyListUseCase;
use GuzzleHttp\Exception\GuzzleException;

class CurrencyListController extends Controller
{
    /**
     * @param CurrencyListUseCase $currencyListUseCase
     */
    public function __construct(
        private readonly CurrencyListUseCase $currencyListUseCase
    ) {}

    /**
     * @throws GuzzleException
     */
    public function __invoke(): ApiSuccessResponse
    {
        $neededCurrencies = array_filter(explode(',', request()->query('currency', '')));

        $currencyListTask = new CurrencyListTask($neededCurrencies);

        $currencyCollection = $this->currencyListUseCase->handle($currencyListTask);

        return new ApiSuccessResponse(
            ResponseStatusEnum::SUCCESS->value,
            data: $currencyCollection
        );
    }
}
