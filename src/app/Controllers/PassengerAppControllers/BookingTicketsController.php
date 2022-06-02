<?php

namespace App\Controllers\PassengerAppControllers;

use App\C\Controller;
use App\Entities\Ticket;
use App\Exceptions\PassenagerAppException\ParameterNotSetException;
use App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter;
use App\Interfaces\BookingTicketsInterfaces\InsertionNewTicket;
use App\Interfaces\BookingTicketsInterfaces\ScheduleOfRouteGetter;
use App\Interfaces\BookingTicketsInterfaces\SeatsGetter;
use App\Interfaces\BookingTicketsInterfaces\TargetAirportsGetter;
use App\Interfaces\PassengerLoginInterfaces\LoginAndPasswordVerification;
use App\Models\PassengerLoginModels\LoginAndPasswordVerificationImpl;
use App\View;
use App\ViewPaths;

class BookingTicketsController extends  Controller {

    protected string $login;

    public function __construct(protected AllAirportsGetter $airportsGetter,
                                protected ScheduleOfRouteGetter $scheduleOfRouteGetter,
                                protected TargetAirportsGetter $targetAirportsGetter,
                                protected SeatsGetter $seatsGetter,
                                protected InsertionNewTicket $insertionNewTicket,
                                LoginAndPasswordVerification $loginAndPasswordVerification) {
        parent::__construct($loginAndPasswordVerification);
        $this -> trackSessionVariable("login", "login", "");
    }
    public function getAllAirports() {

        if($this->verifyAccount()) {
            $airports = $this->airportsGetter->run();
            return json_encode($airports);
        }else {
            return $this->createUnauthorizedView();
        }
    }

    public function getScheduleForRoute() {
        $start = $_POST['start'];
        $target = $_POST['target'];
        if($this->verifyAccount()) {
            return json_encode($this->scheduleOfRouteGetter->run($start, $target));
        }else {
            return $this->createUnauthorizedView();
        }
    }

    public function getTargetAirports() {
        $start = $_POST['start'];
        if($this->verifyAccount()) {
            return json_encode($this->targetAirportsGetter->run($start));
        }else {
            return $this->createUnauthorizedView();
        }
    }

    public function getAvailableSeats() {
        $flightID = $_POST['flightID'];
        if($this->verifyAccount()) {
            return json_encode($this->seatsGetter->run($flightID));
        }else {
            return $this->createUnauthorizedView();
        }
    }

    public function insertTicket() {
        $ticket = Ticket::createForBookingTickets($_POST['flightID'], $_POST['numberOfSeat'], $_POST['passengerID']);
        if($this->verifyAccount()) {
            return json_encode(['answer' => $this->insertionNewTicket->run($ticket)]);
        }else {
            return $this->createUnauthorizedView();
        }
    }
}
