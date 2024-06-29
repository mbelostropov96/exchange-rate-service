<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Support\Str;

class CurrencyDTO extends AbstractDTO
{
    public readonly string $id;
    public readonly string $symbol;
    public readonly ?string $currencySymbol;
    public readonly string $type;
    public readonly string $rateUsd;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data as $key => $datum) {
            $property = Str::camel($key);
            if (property_exists($this, $property)) {
                $this->{$property} = $datum;
            }
        }
    }
}
