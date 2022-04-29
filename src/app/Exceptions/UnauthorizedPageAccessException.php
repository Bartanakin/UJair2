<?php

namespace App\Exceptions;

use PHPUnit\Framework\Exception;

class UnauthorizedPageAccessException extends Exception
{
    protected $message = "The user is not logged in or session has expired.";
}