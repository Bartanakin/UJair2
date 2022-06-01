<?php

namespace App\Entities\SettlementClasses;

class FlightPayment extends Payment
{

    public function __construct($value, $date)
    {
        parent::__construct($value, $date);
        $this -> info = "Tickets value";
    }
}