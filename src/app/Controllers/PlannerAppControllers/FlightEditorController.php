<?php

namespace App\Controllers\PlannerAppControllers;

use App\Entities\Flight;
use App\Interfaces\FindAllFlights;
use App\Interfaces\FlightEditorInterfaces\AvailableAirplaneFinder;
use App\Interfaces\FlightEditorInterfaces\FindFlightData;
use App\Interfaces\FlightEditorInterfaces\FlightCorrectnessChecker;
use App\Interfaces\FlightEditorInterfaces\FlightEditor;
use App\Interfaces\FlightEditorInterfaces\TargetAirportFinder;
use App\View;
use App\ViewPaths;
use DateTime;
use PHPUnit\Exception;
use Ramsey\Uuid\Exception\DateTimeException;

class FlightEditorController
{
    protected ?Flight $editedFlight;
    public function __construct(
        protected FindFlightData $findFlightData,
        protected AvailableAirplaneFinder $availableAirplaneFinder,
        protected TargetAirportFinder $targetAirportFinder,
        protected FlightEditor $flightEditor,
        protected FlightCorrectnessChecker $flightCorrectnessChecker,
        protected FindAllFlights $findAllFlights
    )
    {
        if( isset($_SESSION['editedFlight']) && $_SESSION['editedFlight'] instanceof Flight ){
            $this -> editedFlight = $_SESSION['editedFlight'];
        }
        else{
            $this -> editedFlight = Flight::createNull();
        }
    }

    public function __destruct()
    {
        $_SESSION['editedFlight'] = $this -> editedFlight;
    }

    /**
     * @return Flight|null
     */
    public function getEditedFlight(): ?Flight
    {
        return $this->editedFlight;
    }

    public function setEditedFlightID(int $editedFlightID): void
    {
        $this->editedFlight -> setId($editedFlightID);
    }

    public function cancel(): View{
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }

    private function checkSessionOfEditedFlight(): bool {
        return isset( $_SESSION['editedFlight'] ) && $_SESSION['editedFlight'] instanceof Flight;
    }


    public function confirm(): View{
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }
    public function loadFlight(): View{
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }

    public function selectDate(): View
    {
        if( !isset( $_POST['date'], $_POST['hour'], $_POST['minute']) )
            return View::make(ViewPaths::BAD_REQUEST);
        try{
            $date = DateTime::createFromFormat('Y-m-j H:i',$_POST['date']." ".$_POST['hour'].":".$_POST['minute']);
        }
        catch( DateTimeException $e ){
            return View::make(ViewPaths::EDIT_FLIGHT_PAGE,[ 'errorMessage' => "Incorrect date or time format/", 'editedFlight' => $this -> editedFlight ]);
        }
        $availableAirplanes = $this -> availableAirplaneFinder -> run($date);

        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }
    public function selectAirplane(): View
    {
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }

    public function selectTargetAirportTicketPriceAndConfirm(): View
    {
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }

    public function deleteFlight(): View
    {
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }

    public function acceptConfirmation(): View
    {
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }
}