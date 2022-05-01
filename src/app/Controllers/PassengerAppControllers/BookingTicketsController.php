<?php

namespace App\Controllers\PassengerAppControllers;

use App\Entities\Ticket;
use App\Exceptions\PassenagerAppException\ParameterNotSetException;
use App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter;
use App\Interfaces\BookingTicketsInterfaces\InsertionNewTicket;
use App\Interfaces\BookingTicketsInterfaces\ScheduleOfRouteGetter;
use App\Interfaces\BookingTicketsInterfaces\SeatsGetter;
use App\Interfaces\BookingTicketsInterfaces\TargetAirportsGetter;
use App\View;
use App\ViewPaths;
use PHPUnit\Util\Exception;

class BookingTicketsController {

    public function __construct(protected AllAirportsGetter $airportsGetter,
                                protected ScheduleOfRouteGetter $scheduleOfRouteGetter,
                                protected TargetAirportsGetter $targetAirportsGetter,
                                protected SeatsGetter $seatsGetter,
                                protected InsertionNewTicket $insertionNewTicket) {
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

    public function insertTicket() {
        if (!isset($_GET['flightID'], $_GET['numberOfSeat'], $_GET['passengerID'])) {
            throw new ParameterNotSetException();
        }
        $ticket = Ticket::createForBookingTickets($_GET['flightID'], $_GET['numberOfSeat'], $_GET['passengerID']);
        echo json_encode(['answer' => $this -> insertionNewTicket -> run($ticket)]);
    }
}
