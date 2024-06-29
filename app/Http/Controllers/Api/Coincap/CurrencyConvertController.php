<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Coincap;

use App\Enums\ResponseStatusEnum;
use App\Exceptions\Currency\CurrencyNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Currency\CurrencyConversionRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Task\CurrencyConvertTask;
use App\UseCase\CurrencyConvertUseCase;
use GuzzleHttp\Exception\GuzzleException;

class CurrencyConvertController extends Controller
{
    /**
     * @param CurrencyConvertUseCase $currencyConvertUseCase
     * @param CurrencyConversionRequest $request
     */
    public function __construct(
        private readonly CurrencyConvertUseCase $currencyConvertUseCase,
        private readonly CurrencyConversionRequest $request
    ) {}

    /**
     * @return ApiSuccessResponse
     * @throws CurrencyNotFoundException
     * @throws GuzzleException
     */
    public function __invoke(): ApiSuccessResponse
    {
        $data = $this->request->validated();

        $currencyConvertTask = new CurrencyConvertTask($data['currency_from'], $data['currency_to'], $data['value']);

        $result = $this->currencyConvertUseCase->handle($currencyConvertTask);

        return new ApiSuccessResponse(
            ResponseStatusEnum::SUCCESS->value,
            data: $result
        );
    }
}
