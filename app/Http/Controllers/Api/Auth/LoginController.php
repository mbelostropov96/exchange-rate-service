<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\DTO\UserDTO;
use App\Enums\ResponseStatusEnum;
use App\Exceptions\Auth\ApiAuthenticateException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * @param LoginRequest $request
     * @return ApiSuccessResponse
     * @throws ApiAuthenticateException
     */
    public function __invoke(LoginRequest $request): ApiSuccessResponse
    {
        $data = $request->validated();

        $token = $this->userService->createTokenByUser(new UserDTO($data));

        if ($token === false) {
            throw new ApiAuthenticateException('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return new ApiSuccessResponse(
            ResponseStatusEnum::SUCCESS->value,
            data: [
                'token' => $token,
            ]
        );
    }
}
