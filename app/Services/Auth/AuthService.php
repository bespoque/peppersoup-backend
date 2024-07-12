<?php

namespace App\Services\Auth;


use App\Enums\ErrorCodes;
use App\Helpers\CommonHelpers;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\Register;

use App\Http\Requests\Auth\VerificationRequest;
use App\Models\User;
use App\Models\VerifiedPhoneNumber;
use App\Traits\ResponseCode;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    use ResponseCode;

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $verify  =  User::query()->where('phone', $request->phone)->get();
        if ($verify->count() > 0){
            return $this->loginVerificationCodeRequest($request->phone, "1234","OTP sent to ");
        } else {
            return $this->errorResponse(ErrorCodes::INVALID_CREDENTIALS, "invalid_credentials");
        }
    }


    /**
     * @param Register $request
     * @return JsonResponse
     */
    public function register(Register $request): JsonResponse
    {
        $message= " Registration successful, please a verification code is sent to ";
        $identity = CommonHelpers::code_ref(8);
        $post = new User();
        $post->phone = $request->phone;
        $post->identity = $identity;
        $post->status = 0;
        $post->save();
        return $this->loginVerificationCodeRequest($request->phone, "1234",$message);
    }


    /**
     * @param string $phone_number
     * @param string $otp
     * @param string $message
     * @return JsonResponse
     */
    private function loginVerificationCodeRequest(string $phone_number, string $otp,string $message): JsonResponse
    {
        $collection = VerifiedPhoneNumber::query()->where('phone', $phone_number)->get();
        $verify_code = $otp;
        if ($collection->count() > 0){
            $entry = VerifiedPhoneNumber::find($collection[0]->id);
            $entry->expire_at = Carbon::now()->addMinutes(20);
            $entry->verify_code = $verify_code;
            $entry->update();
        } else {
            $entry = new VerifiedPhoneNumber();
            $entry->expire_at = Carbon::now()->addMinutes(20);
            $entry->phone = $phone_number;
            $entry->verify_code = $verify_code;
            $entry->save();
        }
        return $this->sendSuccess([], $message . $phone_number);
    }


    /**
     * @param VerificationRequest $request
     * @return JsonResponse
     */
    public function verifyVerificationCode(VerificationRequest $request): JsonResponse
    {
        $verify  =  VerifiedPhoneNumber::query()->where('verify_code', $request->verify_code)->get();
        if ($verify->count() > 0){
            $entry = VerifiedPhoneNumber::find($verify[0]->id);
            $entry->expire_at = Carbon::now();
            $entry->update();
            return $this->getToken($verify[0]->phone);
        } else {
            return $this->errorResponse(ErrorCodes::PHONE_NOT_VERIFIED, "invalid otp");
        }
    }


    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function reSendOTP(LoginRequest $request): JsonResponse
    {
        $verify  =  VerifiedPhoneNumber::query()->where('phone', $request->phone)->get();
        if ($verify->count() > 0) {
            return $this->loginVerificationCodeRequest($request->phone, "1234", "OTP sent to ");
        } else {
            return $this->errorResponse(ErrorCodes::NOT_FOUND, "account not found our our system");
        }
    }


    /**
     * @param string $phone_number
     * @return JsonResponse
     */
    private function getToken(string $phone_number): JsonResponse
    {

        $user = User::where('phone', '=', $phone_number)->first();
        try {
            $myTTL = Carbon::now()->addDays(10)->timestamp;
            JWTAuth::factory()->setTTL($myTTL);

            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::fromUser($user)) {
                return $this->errorResponse(ErrorCodes::INVALID_CREDENTIALS, "invalid_credentials");
            }
        } catch (JWTException $e) {
            // something went wrong
            return $this->errorResponse(ErrorCodes::COULD_NOT_CREATE_TOKEN, "could_not_create_token");
        }
        $user_info = User::where('phone', $phone_number)->first();
        $user = $user_info->toArray();

        $data = ["user" => $user, "token" => $token, "expirer_in" => $myTTL];
        return $this->sendSuccess($data, "Login was successful");
    }

}
