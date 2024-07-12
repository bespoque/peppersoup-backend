<?php


namespace App\Exceptions;


use RuntimeException;

class PepperSoupPlaceApplicationException extends RuntimeException
{
    /**
     * @var int
     */
    private int $httpStatus;

    /**
     * @var array
     */
    private array $errors;

    /**
     * @var string
     */
    private string $respCode;

    /**
     * CdlApplicationException constructor.
     * @param string $message
     * @param int|null $httpStatus
     * @param array|null $errors
     * @param string|null $respCode
     */
    public function __construct(string $message, ?int $httpStatus = 400, ?array $errors = [], ?string $respCode = "01")
    {
        parent::__construct($message);
        $this->httpStatus = $httpStatus;
        $this->errors = $errors;
        $this->respCode = $respCode;
    }

    /**
     * @return int
     */
    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return string|null
     */
    public function getRespCode(): ?string
    {
        return $this->respCode;
    }
}
