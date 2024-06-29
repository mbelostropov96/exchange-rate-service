<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\DTO\UserDTO;
use App\Enums\ResponseStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\UserService;

class RegisterController extends Controller
{
    /**
     * @param UserService $userService
     * @param RegisterRequest $request
     */
    public function __construct(
        private readonly UserService $userService,
        private readonly RegisterRequest $request
    ) {}

    /**
     * @param RegisterRequest $request
     * @return ApiSuccessResponse
     */
    public function __invoke(RegisterRequest $request): ApiSuccessResponse
    {
        $data = $this->request->validated();

        $userDto = new UserDTO($data);
        $newUser = $this->userService->createUser($userDto);
        $token = $this->userService->createTokenByUser($userDto);

        return new ApiSuccessResponse(
            ResponseStatusEnum::SUCCESS->value,
            data: [
                'user' => $newUser,
                'token' => $token,
            ]
        );
    }
}
