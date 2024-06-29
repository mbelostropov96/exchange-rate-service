<?php

declare(strict_types=1);

namespace App\Factory;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class CoincapGuzzleFactory
{
    /**
     * @return ClientInterface
     */
    public function create(): ClientInterface
    {
        return new Client([
            'base_uri' => "https://api.coincap.io",
            'timeout' => 20,
            'headers' => [
                'User-Agent' => request()->header('User-Agent'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }
}
