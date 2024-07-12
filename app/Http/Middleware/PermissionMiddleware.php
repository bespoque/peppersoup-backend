<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Exceptions\Permission\UnauthorizedException;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null $permission
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next, $permission = null): mixed
    {

        $email = $request->header("UserId");

        if (! is_null($permission)) {
            $permissions = is_array($permission)
                ? $permission
                : explode('|', $permission);
        }

        if ( is_null($permission) ) {
            $permission = $request->route()->getName();

            $permissions = array($permission);
        }


        foreach ($permissions as $permission) {

            $user = User::query()->where('email',$email)->get();

            $user_role_id = $user[0]->role_id;

            $role = Role::query()->where('name', $permission)->value('id');
            $user_permission = Permission::query()->where('user_roles_id', $user_role_id)->where('role_id', $role)->get();

            if ($user_permission->count() > 0){
                return $next($request);
            }
        }

        return (new UnauthorizedException)->forPermissions($permissions);
    }
}
