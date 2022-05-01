<?php

namespace App\Interfaces\PassengersTicketsInterfaces;

interface AllTicketsForPassengerGetter {
    function run(int $passID) : array;
}