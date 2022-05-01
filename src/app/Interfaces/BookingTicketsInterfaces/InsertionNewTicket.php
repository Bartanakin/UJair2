<?php

namespace App\Interfaces\BookingTicketsInterfaces;


interface InsertionNewTicket
{
    function run(int $flightID, int $seat, int $passengerID): bool;
}