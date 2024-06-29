<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class AbstractDTO implements Arrayable
{
    /**
     * @param string $name
     * @return string|null
     */
    public function __get(string $name): ?string
    {
        $property = Str::camel($name);

        return $this->{$property} ?? null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $value) {
            $result[Str::snake($key)] = $value;
        }

        return $result;
    }
}
