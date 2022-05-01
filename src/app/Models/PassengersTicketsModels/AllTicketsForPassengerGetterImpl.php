<?php

namespace App\Models\PassengersTicketsModels;

use App\DataBaseConnection;
use App\Entities\Ticket;

class AllTicketsForPassengerGetterImpl extends \App\Model implements \App\Interfaces\PassengersTicketsInterfaces\AllTicketsForPassengerGetter
{
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct($dataBaseConnection);
    }

    function run(int $passID): array
    {
        $tickets = [];
        $query = 'SELECT T.NumberOfSeat, FD.DateTimeOfDeparture, FD.StartingAirportName, FD.TargetAirportName FROM Tickets AS T
            JOIN FlightsData AS FD ON T.FlightID = FD.FlightID
            WHERE T.PassengerID = ?;';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute([$passID]);
        while($data = $statement -> fetch()) {
            $tickets[] = Ticket::createForPassengersTickets(
                $data['StartingAirportName'],
                $data['TargetAirportName'],
                $data['NumberOfSeat'],
                $data['DateTimeOfDeparture']
            );
        }
        return $tickets;
    }
}