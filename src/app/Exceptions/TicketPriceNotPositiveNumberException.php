<?php

namespace App\Exceptions;

use PHPUnit\Framework\Exception;

class TicketPriceNotPositiveNumberException extends Exception
{

    public function __construct(string $m)
    {
        parent::__construct($m);
    }
}