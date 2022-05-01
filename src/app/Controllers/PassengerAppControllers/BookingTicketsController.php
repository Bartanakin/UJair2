<?php

namespace App\Controllers\PassengerAppControllers;

use App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter;
use App\Interfaces\BookingTicketsInterfaces\ScheduleOfRouteGetter;
use App\Interfaces\BookingTicketsInterfaces\SeatsGetter;
use App\Interfaces\BookingTicketsInterfaces\TargetAirportsGetter;
use App\View;
use App\ViewPaths;

class BookingTicketsController {

    public function __construct(protected AllAirportsGetter $airportsGetter,
                                protected ScheduleOfRouteGetter $scheduleOfRouteGetter,
                                protected TargetAirportsGetter $targetAirportsGetter,
                                protected  SeatsGetter $seatsGetter) {

    }
    public function getAllAirports() {
//        if( isset($_GET['token']) && $_GET['token'] == 0 ){
//
//            return "";
//        }
//        else{
//            return View::make(ViewPaths::UNAUTHORIZED);
//        }
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

    public function getAvailableSeats() {
        $flightID = $_GET['flightID'];
        echo json_encode($this -> seatsGetter -> run($flightID));
    }
}
