<?php

namespace App\Models;

use App\Entities\Flight;

class FlightWarningAdderImpl implements \App\Interfaces\FlightWarningAdder
{
    private array $airplanesMap = [];

    public function __construct()
    {
    }


    public function addWarnings(): array
    {
        foreach ( $this -> airplanesMap as $airplaneFlights ){
            ksort($airplaneFlights );
            $airplaneFlights = array_values($airplaneFlights);
            /* @var $airplaneFlights Flight[] */
            for( $i = 1; $i < sizeof($airplaneFlights); $i++ ){
                if(
                    $airplaneFlights[$i - 1] -> getTargetAirport() -> getAirportName()
                    !== $airplaneFlights[$i] -> getStartingAirport() -> getAirportName()
                ){
                    $airplaneFlights[$i] -> setWarning(FlightWarnings::AIRPORT_INCOHERENCE_WARNING->value);
                }
            }
        }
        return $this -> unwrapAirplanesMap();
    }

    public function insertFlight(Flight $flight): void
    {
        $this -> airplanesMap
            [$flight -> getAirplane() -> getID()]
            [$flight -> getDateOfDeparture() -> getTimestamp()]
                = $flight;
    }

    private function unwrapAirplanesMap(): array{
        $result = [];
        foreach ($this -> airplanesMap as $airplaneFlights ){
            $result = array_merge($result,$airplaneFlights);
        }
        usort($result,function($x,$y){
            /* @var $x Flight $x Flight */
            /* @var $y Flight $x Flight */
            if( $x -> getId() === $y -> getId() ) return 0;
            if( $x -> getId() < $y -> getId() ) return -1;
            else return 1;
        });
        return $result;
    }
}