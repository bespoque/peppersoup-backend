<?php

namespace App\Enums;

interface ErrorCodes

{
    const SUCCESSFUL = "00";
    const ERROR = "01";
    const EMAIL_NOT_VERIFIED = "02";
    const EMAIL_VERIFIED = "03";
    const PHONE_NOT_VERIFIED = "04";
    const PHONE_VERIFIED = "05";
    const VERIFIED_NOT_REGISTERED = "06";
    const PENDING = "07";
    const INVALID_CREDENTIALS = "08";
    const COULD_NOT_CREATE_TOKEN = "09";
    const NOT_VERIFIED = "10";
    const PERMISSION_ALREADY_EXIST = "11";
    const ROLE_DOES_NOT_EXIST = "12";
    const TEAM_ROLE_DOES_NOT_EXIST = "13";
    const NOT_FOUND ="15";
    const VERIFIED_VIA_PHONE_AND_REGISTERED = "16";
    const VERIFIED_VIA_EMAIL_AND_REGISTERED = "17";
    const USER_DOES_NOT_HAVE_PERMISSION = "18";
    const NOT_AUTHENTICATED = "19";
}
