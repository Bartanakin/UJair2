<?php

namespace App\Models\BookingTickets;

use App\Entities\Flight;
use DateTime;

class ScheduleOfRouteGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\ScheduleOfRouteGetter
{
    protected array $flights = [];
    public function __construct(){
        parent::__construct();
    }

    function run(int $start, int $target): array
    {

        $query = 'SELECT Flights.ID, Flights.DateTimeOfDeparture FROM Flights 
        WHERE Flights.RouteID = (SELECT Routes.ID FROM Routes 
        WHERE Routes.TargetAirportID = ? AND Routes.StartingAirportID = ?);';
        $statement = $this -> dbConnection -> prepare($query);
        $statement -> execute([$target, $start]);
        while($data = $statement -> fetch()) {
            $this->flights[] = new Flight($data['ID'], DateTime::createFromFormat('Y-m-d H:i:s', $data['DateTimeOfDeparture']));
//            echo $data['ID'] . " " . $data['Airport_name'] . '<br/ >';
        }
        return $this -> flights;
    }
}