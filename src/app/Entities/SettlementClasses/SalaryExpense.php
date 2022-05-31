<?php

namespace App\Entities\SettlementClasses;

class SalaryExpense extends Payment
{
    public function __construct($value, $date)
    {
        parent::__construct($value, $date);
        $this -> info = "Salary value";
    }
}