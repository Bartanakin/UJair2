<?php

namespace App\Models\EditCrewModels;

use App\DataBaseConnection;
use App\Entities\Flight;
use App\Interfaces\FlightDataFinderForCrewEdition;
use App\Model;

class FlightDataFinderForCrewEditionImpl extends Model implements FlightDataFinderForCrewEdition
{
    public function __construct(DataBaseConnection $db)
    {
        parent::__construct($db);
    }

    public function findData(int $flightID): Flight
    {
        $statement = $this -> getDBConnection() -> prepare(
            'SELECT DateTimeOfDeparture FROM Flights WHERE ID = ?'
        );
        $statement -> execute([$flightID]);
        return Flight::createForFlightDataFinderForCrewEditionImpl(
            $flightID,
            \DateTime::createFromFormat($statement -> fetch()['DateTimeOfDeparture'],Model::$dateFormat)
        );
    }
}