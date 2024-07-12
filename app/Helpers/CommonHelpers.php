<?php


namespace App\Helpers;


use App\Enums\ErrorCodes;
use App\Exceptions\ApplicationException;
use App\Models\Log;
use App\Models\User;
use App\Traits\ResponseCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommonHelpers
{
    use ResponseCode;


    /**
     * @param $title
     * @param string $separator
     * @param string $language
     * @return string
     */
    public static function str_slug($title, string $separator = '-', string $language = 'en') : string
    {
        return Str::slug($title, $separator, $language);
    }

    /**
     * @param $string
     * @param $table
     * @param $field
     * @param $key
     * @param $value
     * @return array|string|string[]|null
     */
    public static function create_unique_slug($string, $table,$field,$key=NULL,$value=NULL){

        $slug = strtolower(self::str_slug($string));
        $i = 0;
        $params = array ();
        $params[$field] = $slug;
        if($key)$params["$key !="] = $value;

        while (DB::table($table)->where($params)->count()) {
            if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
                $slug .= '-' . ++$i;
            } else {
                $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
            }
            $params [$field] = $slug;
        }
        return $slug;

    }



    /**
     * @param $type
     * @return string
     */
    public static function generateCramp($type) :string
    {
        $mt = explode(' ', microtime());
        $rand = time() . rand(10, 99);
        $time = ((int)$mt[1]) * 1000000 + ((int)round($mt[0] * 1000000));
        $generated = $rand . $time;

        switch ($type) {
            case "comments" :
                return "3060" . $generated;
            case "post" :
                return "3061" . $generated;
            case "user" :
                return "3062" . $generated;
            case "referral_code" :
                return "REF" . $generated;
            default:
                return "3069" . $generated;
        }
    }

    public static function extraRandomRef(): string
    {
        $mt = explode(' ', microtime());
        $rand = time() . rand(10, 99);
        $time = ((int)$mt[1]) * 1000000 + ((int)round($mt[0] * 1000000));
        return $rand . $time;
    }

    /**
     * @param $l
     * @param string $c
     * @return string
     */
    public static function code_ref ($l, string $c = '1234567890') : string {
        for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
        return self::extraRandomRef().$s;
    }

    /**
     * @param $l
     * @param string $c
     * @return string
     */
    public static function code_ref_small ($l, string $c = '1234567890') : string {
        for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
        return $s;
    }

    /**
     * @return string
     */
    public static function code_ref_default () : string {
        return "12345";
    }

    /**
     * @param $email
     * @return bool
     */
    public static function valid_email($email): bool
    {
        return !!filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param $phone
     * @return bool
     */
    public static  function validate_phone_number($phone): bool
    {
        // Allow +, - and . in phone number
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        // Check the lenght of number
        // This can be customized if you want phone number from a specific country
        if (strlen($phone_to_check) < 10 || strlen($phone_to_check) > 17) {
            return false;
        } else {
            return true;
        }
    }

    public static function getUsersProfile($users_)
    {
        foreach ($users_ as $rw) {
            if (!empty($rw['profile_image'])) {
                $image = url('/profile/photo/' . $rw['id'] . '/' . $rw['profile_image']);
            } else {
                $image = null;
            }

            $rw["profile_image"] = $image;
        }
        return $users_;
    }

    public static function log(string $name, string $method, $res): void {
        $new_entry = new Log();
        $new_entry->name = $name;
        $new_entry->method = $method;
        $new_entry->response = $res;
        $new_entry->save();
    }

    /**
     * @return User|JsonResponse
     */
    public  function getUser(): User|JsonResponse
    {
        try {
            if (empty(JWTAuth::parseToken()->authenticate()["id"])){
                throw new ApplicationException("Authentication token expired");
            } else {
                return JWTAuth::parseToken()->authenticate();
            }
        } catch (JWTException){
            return $this->errorResponse(ErrorCodes::NOT_AUTHENTICATED,"authentication token expired");
        }
    }


    /**
     * @param $name
     * @return array|false
     */
    public static function split_name($name): bool|array
    {
        $parts = array();
        while ( strlen( trim($name)) > 0 ) {
            $name = trim($name);
            $string = preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $parts[] = $string;
            $name = trim( preg_replace('#'.preg_quote($string,'#').'#', '', $name ) );
        }

        if (empty($parts)) {
            return false;
        }

        $parts = array_reverse($parts);
        $name = array();
        $name['first_name'] = $parts[0];
        $name['last_name'] = (isset($parts[2])) ? $parts[1]." ".$parts[2] : $parts[1];
        return $name;
    }
}
