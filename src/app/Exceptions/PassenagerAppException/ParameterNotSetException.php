<?php

namespace App\Exceptions\PassenagerAppException;

class ParameterNotSetException extends \Exception
{
    public function __construct()
    {
        parent::__construct("One of the parameters in URL has not been set.");
    }
}