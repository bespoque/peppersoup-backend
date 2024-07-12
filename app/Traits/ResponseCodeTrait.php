<?php


namespace App\Traits;


trait ResponseCodeTrait
{
    /**
     * Status Codes response ok.
     * @var int
     */
    public static int $STATUS_CODE_DONE = 200;
    /**
     * Status Codes response created.
     * @var int
     */
    public static int $STATUS_CODE_CREATED = 201;
    /**
     * Status Codes response deleted.
     * @var int
     */
    public static int $STATUS_CODE_REMOVED = 204;
    /**
     * Status Codes invalid response.
     * @var int
     */
    public static int $STATUS_CODE_NOT_VALID = 400;
    /**
     * Status Codes response not allowed.
     * @var int
     */
    public static int $STATUS_CODE_NOT_ALLOWED = 405;
    /**
     * Status Codes response not created.
     * @var int
     */
    public static int $STATUS_CODE_NOT_CREATED = 406;
    /**
     * Status Codes response not found.
     * @var int
     */
    public static int $STATUS_CODE_NOT_FOUND = 404;
    /**
     * Status Codes response duplicate.
     * @var int
     */
    public static int $STATUS_CODE_CONFLICT = 409;
    /**
     * Status Codes response Unauthorized.
     * @var int
     */
    public static int $STATUS_CODE_PERMISSION = 401;
    /**
     * Status Codes response Access Denied.
     * @var int
     */
    public static int $STATUS_CODE_FORBIDDEN = 403;
    /**
     * Status Codes response Server Error.
     * @var int
     */
    public static int $STATUS_CODE_SERVER_ERROR = 500;
    /**
     * Status Codes response no data.
     * @var int
     */
    public static int $STATUS_CODE_NO_RECORD = 407;


    /**
     * Status Codes response success.
     * @var string
     */
    public static string $STATUS_CODE_SUCCESS = "00";

    /**
     * Status Codes response success.
     * @var string
     */
    public static string $STATUS_CODE_ERROR = "01";


    protected array $statusCodes = [
        'done' => 200,
        'created' => 201,
        'removed' => 204,
        'not_valid' => 400,
        'not_found' => 404,
        'not_record' => 407,
        'conflict' => 409,
        'permissions' => 401,
        'server_error' => 500,
    ];



}
