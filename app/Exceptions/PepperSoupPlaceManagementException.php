<?php

namespace App\Exceptions;

use Exception;

class PepperSoupPlaceManagementException extends Exception
{
    //
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
