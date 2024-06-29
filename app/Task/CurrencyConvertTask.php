<?php

declare(strict_types=1);

namespace App\Task;

class CurrencyConvertTask
{
    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @param string $valueFrom
     */
    public function __construct(
        private readonly string $currencyFrom,
        private readonly string $currencyTo,
        private readonly string $valueFrom
    ) {}

    /**
     * @return string
     */
    public function getCurrencyFrom(): string
    {
        return $this->currencyFrom;
    }

    /**
     * @return string
     */
    public function getCurrencyTo(): string
    {
        return $this->currencyTo;
    }

    /**
     * @return string
     */
    public function getValueFrom(): string
    {
        return $this->valueFrom;
    }
}
