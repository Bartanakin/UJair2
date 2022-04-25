<?php

namespace App\Interfaces\BookingTicketsInterfaces;

interface SeatsGetter
{
    function getMaxSeats(int $flightId): int;
    function getReservedSeats(int $flightId): array;
}