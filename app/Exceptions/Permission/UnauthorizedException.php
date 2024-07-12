<?php

namespace App\Exceptions\Permission;

use App\Enums\ErrorCodes;
use App\Traits\ResponseCode;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException
{
    use ResponseCode;

    private array $requiredRoles = [];

    private array $requiredPermissions = [];

    public static function forRoles(array $roles): self
    {
        $message = 'User does not have the right roles.';

        if (config('permission.display_role_in_exception')) {
            $message .= ' Necessary roles are '.implode(', ', $roles);
        }

        $exception = new static(403, $message, null, []);
        $exception->requiredRoles = $roles;

        return $exception;
    }

    public function forPermissions(array $permissions): JsonResponse
    {
        $message = 'User does not have the right permissions.';
        return $this->customError(ErrorCodes::USER_DOES_NOT_HAVE_PERMISSION,$message,403);
    }

    public static function forRolesOrPermissions(array $rolesOrPermissions): self
    {
        $message = 'User does not have any of the necessary access rights.';

        if (config('permission.display_permission_in_exception') && config('permission.display_role_in_exception')) {
            $message .= ' Necessary roles or permissions are '.implode(', ', $rolesOrPermissions);
        }

        $exception = new static(403, $message, null, []);
        $exception->requiredPermissions = $rolesOrPermissions;

        return $exception;
    }

    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }

    public function getRequiredRoles(): array
    {
        return $this->requiredRoles;
    }

    public function getRequiredPermissions(): array
    {
        return $this->requiredPermissions;
    }
}
