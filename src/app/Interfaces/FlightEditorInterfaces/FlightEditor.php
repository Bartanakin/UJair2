<?php

namespace App\Interfaces\FlightEditorInterfaces;

use App\Entities\Flight;

interface FlightEditor
{
    public function insertFlight(Flight $flight): bool;
    public function editFlight(Flight $flight): bool;
    public function deleteFlight(Flight $flight): bool;
}