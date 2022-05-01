<?php

namespace App\Interfaces\BookingTicketsInterfaces;

use App\Entities\SeatsWrapper;

interface SeatsGetter
{
    function run(int $flightId): SeatsWrapper;
}