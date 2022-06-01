<?php

namespace App\Entities\SettlementClasses;

class SalaryExpense extends Payment
{
    public function __construct($value, $date)
    {
        $this -> info = "Salary value";
        parent::__construct($value, $date);
    }

//    public static function createForAllSalaryMonths(\DateTime $date, float $salary): static
//    {
//        return new static($salary,$date);
//    }
}