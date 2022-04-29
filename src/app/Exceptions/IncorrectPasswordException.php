<?php

namespace App\Exceptions;

use PHPUnit\Framework\Exception;
use Throwable;

class IncorrectPasswordException extends Exception
{
    public function __construct()
    {
        parent::__construct("Incorrect password");
    }
}