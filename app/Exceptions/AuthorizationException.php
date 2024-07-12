<?php

namespace App\Exceptions;

use Exception;

class AuthorizationException extends Exception implements CustomExceptionContract
{

    public function __construct($message)
    {
        parent::__construct($message);
    }

    /**
     * @return integer
     */
    function getHttpResponseCode()
    {
        return 422;
    }

    /**
     * @return string
     */
    function getStatus()
    {
        return "AUTH";
    }

    /**
     * @return mixed
     */
    function getExtraData()
    {
        return null;
    }
}
