<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Support\Str;

class UserDTO extends AbstractDTO
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $email;
    public readonly string $password;

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
