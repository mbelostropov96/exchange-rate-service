<?php

declare(strict_types=1);

namespace App\UseCase;

use App\DTO\CurrencyDTO;
use App\Exceptions\Currency\CurrencyNotFoundException;
use App\Factory\CoincapGuzzleFactory;
use App\Services\CurrencyService;
use App\Task\CurrencyConvertTask;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

class CurrencyConvertUseCase
{
    /**
     * @param CurrencyService $currencyService
     * @param CoincapGuzzleFactory $coincapGuzzleFactory
     */
    public function __construct(
        private readonly CurrencyService $currencyService,
        private readonly CoincapGuzzleFactory $coincapGuzzleFactory
    ) {}

    /**
     * @param CurrencyConvertTask $task
     * @return array
     * @throws GuzzleException
     * @throws CurrencyNotFoundException
     */
    public function handle(CurrencyConvertTask $task): array
    {
        $currencyFrom = $task->getCurrencyFrom();
        $currencyTo = $task->getCurrencyTo();
        $valueFrom = $task->getValueFrom();

        $client = $this->coincapGuzzleFactory->create();

        $currency = $this->currencyService->getCurrencyList($client, [
            $currencyFrom,
            $currencyTo,
        ]);

        /** @var CurrencyDTO|null $currencyFromDto */
        $currencyFromDto = $currency->firstWhere('symbol', '=', $currencyFrom);
        /** @var CurrencyDTO|null $currencyToDto */
        $currencyToDto = $currency->firstWhere('symbol', '=', $currencyTo);

        if ($currencyFromDto === null || $currencyToDto === null) {
            throw new CurrencyNotFoundException('Currency not found', Response::HTTP_BAD_REQUEST);
        }

        $valueTo = $this->currencyService->convertCurrency($currencyFromDto, $currencyToDto, $valueFrom);

        return [
            'currency_from' => $currencyFromDto->symbol,
            'currency_to' => $currencyToDto->symbol,
            'value' => $valueFrom,
            'converted_value' => $valueTo,
            'rate' => bcdiv($currencyToDto->rateUsd, $currencyFromDto->rateUsd, 10),
        ];
    }
}
