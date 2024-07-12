<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\Admin\EnableAndDisableUserRequest;
use App\Services\Admin\AdminService;
use Illuminate\Http\JsonResponse;

class AdminController
{
    private AdminService $adminService;

    /**
     * @param AdminService $adminService

     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }



    public function getDashboard(): JsonResponse
    {
        return $this->adminService->getAdminDashboard();
    }


    public function disableTeamMember(EnableAndDisableUserRequest $request): JsonResponse
    {
        return $this->adminService->disableTeamMember($request);
    }



    public function getAllAudits(): JsonResponse
    {
        return $this->adminService->getAudits();
    }




}
