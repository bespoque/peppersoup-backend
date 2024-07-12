<?php


namespace App\Traits;


use App\Utilities\ErrorCode;
use App\Utilities\GeneralConstants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;

trait ResponseCode
{
    use ResponseCodeTrait;

    public function sendSuccess($data, $resp_description = "Request was successful"): JsonResponse
    {
        return response()->json([
            "resp_code" => GeneralConstants::SUCCESS_CODE,
            "resp_message" => GeneralConstants::SUCCESS_RESP_MESSAGE,
            "resp_description" => $resp_description,
            "data" => $data,
            "errors" => null
        ], self::$STATUS_CODE_DONE);
    }

    public function errorResponse(string $code, $resp_message, $resp_code = "01", $resp_description = ""): JsonResponse
    {
        if ($resp_description == "") {
            $resp_description = $resp_message;
        }
        return response()->json([
            "resp_code" => $resp_code,
            "resp_message" => $resp_message,
            "resp_description" => $resp_description,
            "data" => null,
            "errors" => $this->error($code)
        ], self::$STATUS_CODE_DONE);
    }



    public function customError(string $code, $resp_message, $resp_code = "01", $resp_description = "", int $network_code = 200): JsonResponse
    {
        if ($resp_description == "") {
            $resp_description = $resp_message;
        }
        return response()->json([
            "resp_code" => $resp_code,
            "resp_message" => $resp_message,
            "resp_description" => $resp_description,
            "data" => null,
            "errors" => $this->error($code)
        ], $network_code);
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    private function errorsToObjectFormat(Validator $validator): mixed
    {
        $values = array();
        $numbers = 0;
        foreach ($validator->errors()->toArray() as $row) {
            $da = array(
                "field" => $validator->errors()->keys()[$numbers++],
                "message" => $row[0]
            );
            $values[] = $da;
        }

        throw new HttpResponseException(response()->json([
            'resp_code' =>  GeneralConstants::ERROR_CODE,
            'resp_message' => 'Validation errors: '. $values[0]["message"],
            'resp_description' => 'Validation errors',
            "data" => null,
            'errors' => $values
        ]));
    }


    #[ArrayShape(['code' => "\App\Enums\ErrorCodes", "message" => "array|string"])] private function error(string $code): array
    {
        return  [
            'code' => $code,
            "message" => ErrorCode::errorsMessage($code),
        ];
    }
}
