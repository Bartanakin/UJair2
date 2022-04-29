<?php

namespace App\Exceptions;

use PHPUnit\Framework\Exception;

class IncorrectLoginException extends Exception
{
    public function __construct()
    {
        parent::__construct("Incorrect login");
    }
}