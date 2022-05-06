<?php

namespace App\Interfaces;

use App\Entities\Flight;

interface FlightWarningAdder
{
    public function addWarnings(): array;
    public function insertFlight( Flight $flight ): void;
}