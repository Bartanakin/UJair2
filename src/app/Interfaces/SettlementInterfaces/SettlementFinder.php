<?php

namespace App\Interfaces\SettlementInterfaces;

interface SettlementFinder
{
    public function findSalaries(): array;
    public function findAirplanesLeasing(): array;
    public function flights(): array;
}