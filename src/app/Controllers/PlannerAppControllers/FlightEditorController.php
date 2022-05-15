<?php

namespace App\Controllers\PlannerAppControllers;

use App\Entities\Airplane;
use App\Entities\Airport;
use App\Entities\Flight;
use App\Exceptions\SessionExpiredException;
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
        catch( DateTimeException $e ) {
            return View::make(ViewPaths::EDIT_FLIGHT_PAGE, ['errorMessage' => "Incorrect date or time format", 'editedFlight' => $this->editedFlight]);
        }
        $availableAirplanes = $this -> availableAirplaneFinder -> run($date);

        $this -> editedFlight -> unsetToDate($date);
        $_SESSION['airplanes'] = $availableAirplanes;
        unset($_SESSION['targetAirports']);

        return $this -> createDefaultView();
    }
    public function selectAirplane(): View
    {
        if( !isset( $_POST['airplaneID'], $_POST['airplaneTypeName'], $_POST['startingAirportID'], $_POST['startingAirportName']) )
            return View::make(ViewPaths::BAD_REQUEST);

        try{
            if( !isset( $_SESSION['airplanes'] ) )
                throw new SessionExpiredException("Airplanes list has expired.");

            $this -> editedFlight -> assertAirplaneAndDateForEditFlight();

            $this -> editedFlight -> unsetToAirplane(
                $_POST['airplaneID'],
                $_POST['airplaneTypeName'],
                $_POST['startingAirportID'],
                $_POST['startingAirportName']
            );

            $targetAirports = $this -> targetAirportFinder -> run($this -> editedFlight);
        }catch ( \PDOException $e ){
            return $this->createDefaultView('Invalid airplane data');
        }catch( SessionExpiredException $e ){
            return View::make(ViewPaths::SESSION_EXPIRED);
        }

        $_SESSION['targetAirports'] = $targetAirports;
        return $this -> createDefaultView();
    }

    public function selectTargetAirportTicketPriceAndConfirm(): View
    {
        if( !isset( $_POST['ticketPrice'], $_POST['targetAirportID'], $_POST['targetAirportName']) )
            return View::make(ViewPaths::BAD_REQUEST);
        try{
            $this -> editedFlight -> setTicketPrice($_POST['ticketPrice']);
            $this -> editedFlight -> setTargetAirport(Airport::createTargetForConfirm( $_POST['targetAirportID'], $_POST['targetAirportName']));
            $this -> editedFlight -> assertAirplaneAndDateAndTargetAirportForEditFlight();

            if( !isset( $_SESSION['airplanes'], $_SESSION['targetAirports'] ) )
                throw new SessionExpiredException("Airplanes list or target airplanes list has expired.");
            //if( $this -> editedFlight -> getId() === null )
                //$this -> flightEditor ->
        }catch( SessionExpiredException $e ){
            return View::make(ViewPaths::SESSION_EXPIRED);
        }
        return $this -> createDefaultView();
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

    private function createDefaultView($warning = ""):View{
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE, [
            'editedFlight' => $this -> editedFlight,
            'airplanes' => $_SESSION['airplanes'],
            'targetAirports' => $_SESSION['targetAirports'],
            'warning' => $warning
        ]);
    }
}