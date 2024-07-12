<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Enums\ErrorCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permissions\CreatePermissionRequest;
use App\Models\Role;
use App\Models\UserRoles;
use App\Traits\ResponseCode;
use Illuminate\Http\JsonResponse;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{

    use ResponseCode;


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $permissions = Permission::query()->with('role')->with('user')->paginate(20);
        return $this->sendSuccess($permissions);

    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function userPermission(Request $request): JsonResponse
    {
        $permissions = Permission::query()->where('user_roles_id', $request->user_roles_id)->paginate(20);
        return $this->sendSuccess($permissions);

    }


    /**
     * @param CreatePermissionRequest $request
     * @return JsonResponse
     */
    public function store(CreatePermissionRequest $request): JsonResponse
    {

        $user_role = UserRoles::query()->where('id',$request->user_roles_id)->get();

        if ($user_role->count() > 0){
                if (is_array($request->role_id)){
                    foreach ($request->role_id as $rw){

                        $role = Role::query()->where('id', $rw)->get();
                        if ($role->count() > 0) {
                            $permission = Permission::query()->where('user_roles_id', $request->user_roles_id)->where('role_id', $rw)->get();
                            if ($permission->count() > 0) {
                                return $this->errorResponse(ErrorCodes::PERMISSION_ALREADY_EXIST, "Permission already exist for this Team Member");
                            } else {
                                $permissions = new Permission();
                                $permissions->user_roles_id = $request->user_roles_id;
                                $permissions->role_id = $rw;
                                $permissions->name = $role[0]->title;
                                $permissions->save();
                            }
                        }
                    }
                    return $this->sendSuccess([]);

                } else {
                    $role = Role::query()->where('id', $request->role_id)->get();
                    if ($role->count() > 0) {
                        $permission = Permission::query()->where('user_roles_id', $request->user_roles_id)->where('role_id', $request->role_id)->get();
                        if ($permission->count() > 0) {
                            return $this->errorResponse(ErrorCodes::PERMISSION_ALREADY_EXIST, "Permission already exist for this Team Member");
                        } else {
                            $permissions = new Permission();
                            $permissions->user_roles_id = $request->user_roles_id;
                            $permissions->role_id = $request->role_id;
                            $permissions->name = $role[0]->title;
                            $permissions->save();

                            return $this->sendSuccess($permissions);
                        }
                    } else {
                        return $this->errorResponse(ErrorCodes::ROLE_DOES_NOT_EXIST,"role does not exist");
                    }

                }


        } else {
            return $this->errorResponse(ErrorCodes::TEAM_ROLE_DOES_NOT_EXIST,"Team Role does not exist");
        }
    }


    /**
     * @param Permission $permission
     * @return JsonResponse
     */
    public function destroy(Permission $permission): JsonResponse
    {
        $permissions = $permission->delete();
        return $this->sendSuccess($permissions);
    }
}
