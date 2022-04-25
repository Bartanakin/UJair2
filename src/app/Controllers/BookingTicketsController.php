<?php

namespace App\Controllers;

use App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter;

class BookingTicketsController {
    protected array $airports = [];

    public function __construct(protected AllAirportsGetter $airportsGetter) {

    }
    public function getAllAirports() {
        $airports = $this -> airportsGetter -> run();
        echo json_encode($airports);
    }
}
