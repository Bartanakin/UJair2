<?php

namespace App\Entities\SettlementClasses;

class TicketIncome extends Payment
{

    public function __construct($value, $date)
    {
        parent::__construct($value, $date);
        $this -> info = "Tickets value";
    }
}