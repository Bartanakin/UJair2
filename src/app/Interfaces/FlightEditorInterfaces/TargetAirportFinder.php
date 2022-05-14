<?php

namespace App\Interfaces\FlightEditorInterfaces;

use App\Entities\Flight;

interface TargetAirportFinder
{

    public function run(Flight $editedFlight): array;
}