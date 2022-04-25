<?php

namespace App\Interfaces\BookingTicketsInterfaces;

interface TargetAirportsGetter
{
    function run(int $start): array;
}