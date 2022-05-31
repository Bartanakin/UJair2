<?php

namespace App\Entities\SettlementClasses;

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
}