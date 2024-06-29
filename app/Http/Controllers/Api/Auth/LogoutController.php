<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Enums\ResponseStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiSuccessResponse;

class LogoutController extends Controller
{
    /**
     * @return ApiSuccessResponse
     */
    public function __invoke(): ApiSuccessResponse
    {
        auth()->logout();

        return new ApiSuccessResponse(ResponseStatusEnum::SUCCESS->value);
    }
}
