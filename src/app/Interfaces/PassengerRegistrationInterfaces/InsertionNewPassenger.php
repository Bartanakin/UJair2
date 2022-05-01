<?php

namespace App\Interfaces\PassengerRegistrationInterfaces;

use App\Entities\PersonClasses\Passenger;

interface InsertionNewPassenger {
    function run(Passenger $passenger) : bool;
}