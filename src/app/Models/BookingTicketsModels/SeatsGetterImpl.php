<?php

namespace App\Models\BookingTicketsModels;

use App\DataBaseConnection;
use App\Entities\SeatsWrapper;

class SeatsGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\SeatsGetter
{   protected array $availableSeats = [];
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct(  $dataBaseConnection);
    }

    function run(int $flightId): SeatsWrapper
    {
        $reservedSeats = [];
        $maxSeats = 0;

        $query = 'SELECT RSFF.NumberOfSeat FROM ReservedSeatsForFlight AS RSFF WHERE RSFF.FlightID = ?;';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute([$flightId]);

        $query2 = 'SELECT AT.Max_number_of_passangers FROM Flights AS F
            JOIN Airplanes AS A ON F.AirPlaneID = A.ID
            JOIN AirplaneTypes AS AT ON A.AirplaneTypeID = AT.ID
            WHERE ? = F.ID;';
        $statement2 = $this -> getDBConnection() -> prepare($query2);
        $statement2 -> execute([$flightId]);
        while($data = $statement -> fetch()) {
            $reservedSeats[] = $data['NumberOfSeat'];

        }

        while($data = $statement2 -> fetch()) {
            $maxSeats = $data['Max_number_of_passangers'];
        }

        for ($i = 1; $i <= $maxSeats; $i++) {
            if (!in_array($i, $reservedSeats)) {
                $this -> availableSeats[] = $i;
            }
        }

        return SeatsWrapper::createForBookingTickets($this -> availableSeats);
    }
}