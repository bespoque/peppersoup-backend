<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\Register;

use App\Http\Requests\Auth\VerificationRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }



    /**
     * @param Register $request
     * @return JsonResponse
     */
    public function register(Register $request): JsonResponse
    {
       return $this->authService->register($request);
    }


    /**
     * @param VerificationRequest $request
     * @return JsonResponse
     */
    public function otpVerification(VerificationRequest $request): JsonResponse
    {
        return $this->authService->verifyVerificationCode($request);
    }


    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function retryingOtpRequest(LoginRequest $request): JsonResponse
    {
        return $this->authService->reSendOTP($request);
    }

}
