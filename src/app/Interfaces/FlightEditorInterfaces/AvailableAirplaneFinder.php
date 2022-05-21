<?php

namespace App\Interfaces\FlightEditorInterfaces;

interface AvailableAirplaneFinder
{
    public function run(\DateTime $date): array;

}