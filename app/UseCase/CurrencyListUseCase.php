<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Factory\CoincapGuzzleFactory;
use App\Services\CurrencyService;
use App\Task\CurrencyListTask;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class CurrencyListUseCase
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
     * @param CurrencyListTask $task
     * @return Collection
     * @throws GuzzleException
     */
    public function handle(CurrencyListTask $task): Collection
    {
        $neededCurrencies = $task->getCurrencyList();

        $client = $this->coincapGuzzleFactory->create();

        $currencyCollection = $this->currencyService->getCurrencyList($client, $neededCurrencies);

        return $this->currencyService->toResponseList($currencyCollection);
    }
}
