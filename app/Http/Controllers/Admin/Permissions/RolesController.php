<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Enums\ErrorCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permissions\AssignRoleToUserRequest;
use App\Http\Requests\Admin\Permissions\CreateRoleRequest;
use App\Http\Requests\Admin\Permissions\DeleteRoleRequest;
use App\Http\Requests\Admin\Permissions\UpdateRoleRequest;
use App\Models\User;
use App\Models\UserRoles;
use App\Traits\ResponseCode;
use Illuminate\Http\JsonResponse;
use App\Models\Role;

class RolesController extends Controller
{

    use ResponseCode;


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $roles = Role::query()->orderBy('id','DESC')->paginate(20);
        return $this->sendSuccess($roles);
    }


    /**
     * @return JsonResponse
     */
    public function teamRoles(): JsonResponse
    {
        $roles = UserRoles::query()->orderBy('id','DESC')->paginate(20);
        return $this->sendSuccess($roles);
    }


    /**
     * @param CreateRoleRequest $request
     * @return JsonResponse
     */
    public function store(CreateRoleRequest $request): JsonResponse
    {
        $roles = UserRoles::create(['name' => $request->get('name')]);
        return $this->sendSuccess($roles);
    }


    /**
     * @param UpdateRoleRequest $request
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request): JsonResponse
    {
        $role = UserRoles::find($request->role_id);
        $role->name = $request->name;
        $role->update();
        return $this->sendSuccess($role);
    }


    /**
     * @param DeleteRoleRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteRoleRequest $request): JsonResponse
    {
        $role = UserRoles::find($request->role_id);
        $role->delete();
        return $this->sendSuccess($role);
    }


    /**
     * @param AssignRoleToUserRequest $request
     * @return JsonResponse
     */
    public function assignUserARole(AssignRoleToUserRequest $request): JsonResponse
    {
        $roles = UserRoles::query()->where('id', $request->role_id)->get();
        if ($roles->count() > 0){
            $user = User::find($request->user_id);
            $user->role_id = $request->role_id ?? null;
            $user->update();
        } else {
            return $this->errorResponse(ErrorCodes::TEAM_ROLE_DOES_NOT_EXIST,"Team Role not found");
        }
        return $this->sendSuccess([]);
    }
}
