<?php

namespace App\Utilities;

use App\Enums\ErrorCodes;

class ErrorCode
{
    public static function errorsMessage($code): array|string
    {
        $errorCodes =
            [
                ErrorCodes::SUCCESSFUL => "Successful",
                ErrorCodes::ERROR => "Error",
                ErrorCodes::EMAIL_NOT_VERIFIED => "Email Not Verified",
                ErrorCodes::EMAIL_VERIFIED => "Email Verified",
                ErrorCodes::PHONE_NOT_VERIFIED => "Phone Number Not Verified",
                ErrorCodes::PHONE_VERIFIED => "Phone Verified",
                ErrorCodes::VERIFIED_NOT_REGISTERED => "Verified But Not Registered",
                ErrorCodes::PENDING => "pending",
                ErrorCodes::INVALID_CREDENTIALS => "invalid credentials",
                ErrorCodes::COULD_NOT_CREATE_TOKEN => "could not create token",
                ErrorCodes::NOT_VERIFIED => "user not verified",
                ErrorCodes::PERMISSION_ALREADY_EXIST => "Permission already exist for this Team Member",
                ErrorCodes::ROLE_DOES_NOT_EXIST => "role does not exist",
                ErrorCodes::NOT_FOUND => "Not found",
                ErrorCodes::TEAM_ROLE_DOES_NOT_EXIST => "Team Role does not exist",
                ErrorCodes::VERIFIED_VIA_PHONE_AND_REGISTERED => "Verified via phone and already registered",
                ErrorCodes::VERIFIED_VIA_EMAIL_AND_REGISTERED => "Verified via email and already registered",
                ErrorCodes::USER_DOES_NOT_HAVE_PERMISSION => "User does not have the right permissions",
            ];

        if(empty($code)){
            return $errorCodes;
        } elseif(array_key_exists($code, $errorCodes)){
            return $errorCodes[$code];
        } else{
            return "Unknown Error";
        }
    }
}
