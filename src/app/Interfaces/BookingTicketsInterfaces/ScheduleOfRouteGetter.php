<?php

namespace App\Interfaces\BookingTicketsInterfaces;

interface ScheduleOfRouteGetter
{
    function run(int $start, int $target): array;
}