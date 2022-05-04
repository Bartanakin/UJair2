<?php

namespace App\Models\FlightEditorModels;

use App\DataBaseConnection;
use App\Entities\Flight;

class FindFlightDataImpl extends \App\Model implements \App\Interfaces\FlightEditorInterfaces\FindFlightData
{

    public function __construct(DataBaseConnection $dataBaseConnection)
    {
        parent::__construct($dataBaseConnection);
    }

    public function findFlightData(int $flightID): Flight
    {
        // TODO: Implement findFlightData() method.
    }
}