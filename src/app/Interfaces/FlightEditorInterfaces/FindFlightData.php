<?php

namespace App\Interfaces\FlightEditorInterfaces;

use App\Entities\Flight;

interface FindFlightData
{
    public function findFlightData(int $flightID): Flight;
}