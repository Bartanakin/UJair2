<?php

namespace App\Controllers\PassengerAppControllers;

use App\Interfaces\PassengersTicketsInterfaces\AllTicketsForPassengerGetter;

class PassengersTicketsController
{
    public function __construct(protected AllTicketsForPassengerGetter $allTicketsGetter) {

    }

    public function getTicketsForPassengerID() {
        echo json_encode($this -> allTicketsGetter -> run($_GET['passID']));
    }
}