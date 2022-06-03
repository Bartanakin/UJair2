<?php

namespace App\Models\BookingTicketsModels;

use App\DataBaseConnection;
use App\Entities\Flight;
use DateTime;

class ScheduleOfRouteGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\ScheduleOfRouteGetter
{
    protected array $flights = [];
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct($dataBaseConnection);
    }

    function run(int $start, int $target): array
    {

        $query = 'SELECT Flights.ID, Flights.DateTimeOfDeparture FROM Flights 
        WHERE Flights.RouteID = (SELECT Routes.ID FROM Routes 
        WHERE Routes.TargetAirportID = ? AND Routes.StartingAirportID = ? AND Flights.Canceled = FALSE AND Flights.DateTimeOfDeparture > NOW());';

        //$this -> getDBConnection() -> beginTransaction();

        $statement = $this -> getDBConnection() -> prepare($query);
        $success = $statement -> execute([$target, $start]);

        //$this -> getDBConnection() -> commit();
        //$this -> getDBConnection() -> rollBack();

        while($data = $statement -> fetch()) {
            $this->flights[] = Flight::createForBookingTickets($data['ID'], $data['DateTimeOfDeparture']);
//            echo $data['ID'] . " " . $data['Airport_name'] . '<br/ >';
        }
        return $this -> flights;
    }
}