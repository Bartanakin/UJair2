<?php

namespace App\Interfaces;

use App\Entities\Flight;

interface FlightDataFinderForCrewEdition
{
    public function findData(int $flightID): Flight;
}