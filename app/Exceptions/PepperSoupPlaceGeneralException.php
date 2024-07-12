<?php

namespace App\Exceptions;

class PepperSoupPlaceGeneralException extends \RuntimeException
{
     /**
     * @var int
     */
    private $httpStatus;

    /**
     * @var
     */
    private $errors = [];

    /**
     * CdlApplicationException constructor.
     * @param string $message
     * @param int|null $httpStatus
     * @param array|null $errors
     */
    public function __construct(string $message, ?int $httpStatus = 400, ?array $errors = [])
    {
        parent::__construct($message);
        $this->httpStatus = $httpStatus;
        $this->errors = $errors;
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
}
