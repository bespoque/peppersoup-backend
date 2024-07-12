<?php
namespace App\Http\Middleware;

use App\Enums\ErrorCodes;
use App\Traits\ResponseCode;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    use ResponseCode;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->errorResponse(ErrorCodes::ERROR,'Token is Invalid');
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->errorResponse(ErrorCodes::ERROR,'Token is Expired');
        } catch (Exception $e) {
            return $this->errorResponse(ErrorCodes::ERROR,'Authorization Token not found');
        }
        return $next($request);
    }
}
