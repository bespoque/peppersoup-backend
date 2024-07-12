<?php

namespace App\Services\User;

use App\Helpers\CommonHelpers;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\User;
use App\Traits\ResponseCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserService
{

    use ResponseCode;



    /**
     * @return JsonResponse
     */
    public function getDashboard(): JsonResponse
    {
        $items = [];
        return $this->sendSuccess($items);
    }

    /**
     * @return JsonResponse
     */
    public function getAccountInfo(): JsonResponse
    {
        $user = (new CommonHelpers)->getUser();
        $user_info  =  User::where('id', $user["id"])->get();
        return $this->sendSuccess($user_info);
    }


    /**
     * @param UpdateProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = (new CommonHelpers)->getUser();
        $fullname = CommonHelpers::split_name($request->fullname);

        $post = User::find($user["id"]);
        $post->firstname = $fullname["first_name"] ?? $post->firstname;
        $post->lastname = $fullname["last_name"] ?? $post->lastname;
        $post->email = $request->email ??  $post->email;

        $post->update();
        return $this->sendSuccess($post);
    }


}
