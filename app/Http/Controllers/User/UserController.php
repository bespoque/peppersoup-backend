<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UpdateProfileRequest;
use App\Services\User\UserService;
use App\Traits\ResponseCode;
use Illuminate\Http\JsonResponse;

class UserController
{

    use ResponseCode;


    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct( UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @return JsonResponse
     */
    public function getDashboard(): JsonResponse
    {
        return $this->userService->getDashboard();
    }


    /**
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        return $this->userService->updateProfile($request);
    }


    public function accountInformation(): JsonResponse
    {
        return $this->userService->getAccountInfo();
    }




}
