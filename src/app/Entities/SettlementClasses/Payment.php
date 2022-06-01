<?php

namespace App\Entities\SettlementClasses;

use App\Model;

abstract class Payment
{
    protected string $info = "";
    protected float $value;
    protected \DateTime $date;

    public function __construct($value,$date)
    {
        $this -> date = $date;
        $this -> value = $value;
    }

    public function getInfo(): string { return $this -> info; }
    public function getValue(): float { return $this -> value; }
    public function getDate(): \DateTime { return $this -> date; }
    public function getDateString(): string { return $this -> date -> format("Y-m-d"); }

    public static function createForAllSalaryMonths($date,$value): static {
        return new static($value,$date);
    }
}