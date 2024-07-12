<?php

namespace App\Exceptions;

use RuntimeException;

class ApplicationException extends RuntimeException
{
    /**
     * @var int
     */
    private int $httpStatus;

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
     * @return array|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }
}
