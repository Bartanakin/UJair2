<?php

namespace App\Models\BookingTickets;

class SeatsGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\SeatsGetter
{
    public function __construct(){
        parent::__construct();
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