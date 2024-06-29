<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;

class UserService
{
    /**
     * @param UserDTO $userDto
     * @return UserDTO
     */
    public function createUser(UserDTO $userDto): UserDTO
    {
        /** @var User $user */
        $user = (new User())->newQuery()
            ->create($userDto->toArray());

        return new UserDTO($user->toArray());
    }

    /**
     * @param UserDTO $userDto
     * @return string|false
     */
    public function createTokenByUser(UserDTO $userDto): string|false
    {
        return auth()->attempt([
            'email' => $userDto->email,
            'password' => $userDto->password,
        ]);
    }
}
