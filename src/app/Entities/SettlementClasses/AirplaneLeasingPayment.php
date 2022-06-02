<?php

namespace App\Entities\SettlementClasses;

class AirplaneLeasingPayment extends Payment
{
    public function __construct($value, $date)
    {
        parent::__construct($value, $date);
        $this -> info = "Airplane leasing cost";
    }

//    public static function createForAllSalaryMonths($date,$value): static {
//        return new static($value,$date);
//    }
}