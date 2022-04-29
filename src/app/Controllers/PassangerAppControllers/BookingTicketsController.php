<?php

namespace App\Controllers;

use App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter;
use App\Interfaces\BookingTicketsInterfaces\ScheduleOfRouteGetter;
use App\Interfaces\BookingTicketsInterfaces\TargetAirportsGetter;

class BookingTicketsController {

    public function __construct(protected AllAirportsGetter $airportsGetter,
                                protected ScheduleOfRouteGetter $scheduleOfRouteGetter,
                                protected TargetAirportsGetter $targetAirportsGetter) {

    }
    public function getAllAirports() {
        $airports = $this -> airportsGetter -> run();
        echo json_encode($airports);
    }

    public function getScheduleForRoute() {
        $start = $_GET['start'];
        $target = $_GET['target'];
        echo json_encode($this -> scheduleOfRouteGetter -> run($start, $target));
    }

    public function getTargetAirports() {
        $start = $_GET['start'];
        echo json_encode($this -> targetAirportsGetter -> run($start));
    }
}
