<?php

namespace App\Exceptions;

use App\Traits\ResponseCodeTrait;
use App\Utilities\GeneralConstants;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseCodeTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Exception|Throwable $e
     * @return void
     * @throws Throwable
     */
    public function report(Exception|Throwable $e): void
    {
        parent::report($e);
    }


    /**
     * @param $request
     * @param Exception|Throwable $exception
     * @return JsonResponse
     */
    public function render($request, Exception|Throwable $exception): JsonResponse
    {
        return response()->json([
        "resp_code" => GeneralConstants::ERROR_CODE,
        "resp_message" => GeneralConstants::ERROR_RESP_MESSAGE,
        "resp_description" => "an error occurred while processing your request",
        "data" => array(
            "error" =>$exception->getMessage()
        ),
        "errors" => null
    ], self::$STATUS_CODE_DONE);

    }

}
