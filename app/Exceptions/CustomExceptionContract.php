<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/23/2021
 * Time: 8:48 AM
 */

namespace App\Exceptions;


interface CustomExceptionContract
{

    /**
     * @return integer
     */
    function getHttpResponseCode();

    /**
     * @return string
     */
    function getStatus();

    /**
     * @return mixed
     */
    function getExtraData();

}