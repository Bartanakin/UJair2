<?php

namespace App\Models;

use App\DataBaseConnection;
use App\Entities\Flight;
use App\Interfaces\FlightWarningAdder;
use Ds\Map;

class FindAllFlightsImpl extends \App\Model implements \App\Interfaces\FindAllFlights
{

    protected array $airplanesMap = [] ;
    public function __construct(
        DataBaseConnection $dataBaseConnection ,
        protected FlightWarningAdder $flightWarningAdder
    )
    {
        parent::__construct($dataBaseConnection);
    }

    public function findAllFlights(): array
    {
        $statement = $this -> dataBaseConnection -> getPDO() -> prepare('CALL findAllFlights()');
        $statement -> execute();

        while ( $row = $statement -> fetch()){
            $flight = Flight::createForAllFlights(
                 $row['FlightID'],
                 $row['StartingAirportName'],
                 $row['TargetAirportName'],
                 $row['DateTimeOfDeparture'],
                 $row['AirplaneID'],
                 $row['AirplaneTypeName'],
                 $row['Price']
            );
            $this -> flightWarningAdder -> insertFlight($flight);
        }
        return $this -> flightWarningAdder -> addWarnings();
    }

}