<?php

namespace App\Services\Permission\Contracts;

interface Wildcard
{
    /**
     * @param  string|Wildcard  $permission
     */
    public function implies($permission): bool;
}
