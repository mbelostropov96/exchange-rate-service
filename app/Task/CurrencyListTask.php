<?php

declare(strict_types=1);

namespace App\Task;

class CurrencyListTask
{
    /**
     * @param array $currencyList
     */
    public function __construct(
        private readonly array $currencyList = []
    ) {}

    /**
     * @return array
     */
    public function getCurrencyList(): array
    {
        return $this->currencyList;
    }
}
