<?php

namespace App\Services\Admin;

use App\Enums\ErrorCodes;
use App\Helpers\CommonHelpers;
use App\Http\Requests\Admin\EnableAndDisableUserRequest;
use App\Http\Requests\Admin\RegisterAdminRequest;
use App\Models\User;
use App\Models\UserRoles;
use App\Traits\ResponseCode;
use Illuminate\Http\JsonResponse;
use OwenIt\Auditing\Models\Audit;

class AdminService
{
    use ResponseCode;

    /**
     * @return JsonResponse
     */
    public function getAllClient(): JsonResponse
    {
        $result = User::query()->paginate(20);
        return $this->sendSuccess($result);
    }



    /**
     * @return JsonResponse
     */
    public function getAdminDashboard(): JsonResponse
    {
        $items = [];
        return $this->sendSuccess($items);
    }



    /**
     * @param RegisterAdminRequest $request
     * @return JsonResponse
     */
    public function register(RegisterAdminRequest $request): JsonResponse
    {
        $role = UserRoles::query()->where('id', $request->team_role_id)->get()->count();

            if ($role < 0){
                return $this->errorResponse(ErrorCodes::ERROR,"No Team Role Found with that ID");
            }

            $identity = CommonHelpers::code_ref(8);
            $post = new User();
            $post->firstname = $request->firstname;
            $post->lastname = $request->lastname;
            $post->email = $request->email;
            $post->password = bcrypt($request->password);
            $post->phone = $request->phone;
            $post->identity = $identity;
            $post->status = 1;
            $post->is_admin = 1;
            $post->role_id = $request->team_role_id;
            $post->save();
            return $this->sendSuccess($post);
    }

    public function disableTeamMember(EnableAndDisableUserRequest $request): JsonResponse
    {
        $update_entry = User::find($request->user_id);
        $update_entry->status = $request->status ?? 0;
        $update_entry->update();
        return $this->sendSuccess($update_entry);
    }

    /**
     * @return JsonResponse
     */
    public function getAudits(): JsonResponse
    {
        $results = Audit::query()->paginate(20);
        return $this->sendSuccess($results);
    }


}
