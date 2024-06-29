<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CurrencyDTO;
use App\Enums\CurrencySymbolEnum;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Request;

class CurrencyService
{
    /** @var int коммисия на обмен валюты */
    public const PERCENT_COMMISSION = 2;

    /**
     * @param ClientInterface $client
     * @param array $neededCurrencies
     * @return Collection
     * @throws GuzzleException
     */
    public function getCurrencyList(ClientInterface $client, array $neededCurrencies = []): Collection
    {
        $response = $client->request(Request::METHOD_GET, '/v2/rates');
        $currencies = json_decode($response->getBody()->getContents(), true);

        $currencyCollection = new Collection();
        foreach ($currencies['data'] as $value) {
            $currencyCollection->push(new CurrencyDTO([
                'id' => $value['id'],
                'symbol' => $value['symbol'],
                'currencySymbol' => $value['currencySymbol'],
                'type' => $value['type'],
                'rateUsd' => $value['rateUsd'],
            ]));
        }

        if ($neededCurrencies !== []) {
            $currencyCollection = $currencyCollection->filter(static function (CurrencyDTO $currency) use ($neededCurrencies) {
                return in_array($currency->symbol, $neededCurrencies, true);
            });
        }

        return $currencyCollection->sortBy('rateUsd')->values();
    }

    /**
     * @param CurrencyDTO $currencyFrom
     * @param CurrencyDTO $currencyTo
     * @param string $valueFrom
     * @param int $commission
     * @return string
     */
    public function convertCurrency(
        CurrencyDTO $currencyFrom,
        CurrencyDTO $currencyTo,
        string $valueFrom,
        int $commission = self::PERCENT_COMMISSION
    ): string
    {
        // Если идет обмен из BTC в USD - округляем до 0.01
        if (
            $currencyFrom->symbol === CurrencySymbolEnum::BTC->value
            && $currencyTo->symbol === CurrencySymbolEnum::USD->value
        ) {
            $decimals = 2;
        } else {
            $decimals = 10;
        }

        $valueTo = bcdiv($valueFrom, bcdiv($currencyTo->rateUsd, $currencyFrom->rateUsd, 10), $decimals);

        return bcmul($valueTo, (string)((100 - $commission) / 100), $decimals);
    }

    /**
     * @param Collection $currencyCollection
     * @param int $commission
     * @return Collection
     */
    public function toResponseList(Collection $currencyCollection, int $commission = self::PERCENT_COMMISSION): Collection
    {
        $newCollection = new Collection();

        $currencyCollection->each(static function (CurrencyDTO $currencyDTO) use ($newCollection, $commission) {
            $rateUseWithCommission = bcmul($currencyDTO->rateUsd, (string)((100 - $commission) / 100), 10);

            $newCollection->put($currencyDTO->symbol, $rateUseWithCommission);
        });

        return $newCollection;
    }
}
