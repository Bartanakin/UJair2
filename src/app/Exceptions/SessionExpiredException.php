<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class SessionExpiredException extends \Exception
{
    public function __construct(string $message = "Session has expired")
    {
        parent::__construct($message);
    }
}