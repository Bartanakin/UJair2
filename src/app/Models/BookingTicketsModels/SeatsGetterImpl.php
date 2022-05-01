<?php

namespace App\Models\BookingTicketsModels;

use App\DataBaseConnection;

class SeatsGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\SeatsGetter
{
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct(  $dataBaseConnection);
    }

    function getMaxSeats(int $flightId): int
    {
        // TODO: Implement getMaxSeats() method.
    }

    function getReservedSeats(int $flightId): array
    {
        // TODO: Implement getReservedSeats() method.
    }
}