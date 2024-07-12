<?php

namespace App\Http\Middleware;

use App\Enums\ErrorCodes;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseCode;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class RequestMiddleware extends Controller
{
    use ResponseCode;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {

        $user_id = $request->header("UserId");
        $user_type = $request->header("UserType") ?? null;

        if (!isset($user_id)) {
            return $this->errorResponse(ErrorCodes::ERROR, "User id is required to make any request", self::$STATUS_CODE_ERROR);
        } else {
            $user = User::query()->where('email', $user_id)->get();
            if ($user->count() == 0){
                return $this->errorResponse(ErrorCodes::ERROR, "User id is required to make any request", self::$STATUS_CODE_ERROR);
            }
        }


        if (!isset($user_type)) {
            return $this->errorResponse(ErrorCodes::ERROR, "User Type key is required to make any request", self::$STATUS_CODE_ERROR);
        } else {
            $user = User::query()->where('email', $user_id)->get();
            if ($user[0]["is_admin"] != 1){
                return $this->errorResponse(ErrorCodes::ERROR, "User Type is required to make any request", self::$STATUS_CODE_ERROR);
            }
        }

        return $next($request);
    }

}
