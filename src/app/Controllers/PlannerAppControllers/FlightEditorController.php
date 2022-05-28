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
use App\Model;
use App\View;
use App\ViewPaths;
use DateTime;
use PHPUnit\Exception;
use Ramsey\Uuid\Exception\DateTimeException;

class FlightEditorController
{
    protected ?Flight $editedFlight;
    protected ?array $airplanes;
    protected ?array $targetAirports;
    protected ?string $warning;
    public function __construct(
        protected FindFlightData $findFlightData,
        protected AvailableAirplaneFinder $availableAirplaneFinder,
        protected TargetAirportFinder $targetAirportFinder,
        protected FlightEditor $flightEditor,
        protected FlightCorrectnessChecker $flightCorrectnessChecker,
        protected FindAllFlights $findAllFlights
    )
    {
        $this -> restoreFromSession('editedFlight','editedFlight',Flight::createNull());
        $this -> restoreFromSession('airplanes','airplanes',[]);
        $this -> restoreFromSession('targetAirports','targetAirports',[]);
        $this -> restoreFromSession('warning','warning','');
    }

    private function restoreFromSession(string $propName, string $sesName, mixed $default){
        if( isset($_SESSION[$sesName])){
            $this -> $propName = $_SESSION[$sesName];
        }
        else{
            $this->resetProp($propName,$sesName,$default);
        }
    }
    private function resetProp(string $propName, string $sesName, mixed $default){
        $this -> $propName = $default;
        unset($_SESSION[$sesName]);
    }

    public function __destruct()
    {
        $_SESSION['editedFlight'] = $this -> editedFlight;
        $_SESSION['airplanes'] = $this -> airplanes;
        $_SESSION['targetAirports'] = $this -> targetAirports;
        $_SESSION['warning'] = $this -> warning;
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
        $this -> airplanes = $this -> availableAirplaneFinder -> run($date);

        $this -> editedFlight -> unsetToDate($date);
        $this -> resetProp('targetAirports','targetAirports',[]);


        return $this -> createDefaultView();
    }
    public function selectAirplane(): View
    {
        if( !isset( $_POST['airplaneID'], $_POST['airplaneTypeName'], $_POST['startingAirportID'], $_POST['startingAirportName']) )
            return View::make(ViewPaths::BAD_REQUEST);

        try{
            if( !$this -> airplanes )
                throw new SessionExpiredException("Airplanes list has expired.");

            $this -> editedFlight -> assertDate();

            $this -> editedFlight -> unsetToAirplane(
                $_POST['airplaneID'],
                $_POST['airplaneTypeName'],
                $_POST['startingAirportID'],
                $_POST['startingAirportName']
            );

            $this -> targetAirports = $this -> targetAirportFinder -> run($this -> editedFlight);
        }
//        catch ( \PDOException $e ){
//            return $this->createDefaultView('Invalid airplane data');
//        }
        catch( SessionExpiredException $e ){
            return View::make(ViewPaths::SESSION_EXPIRED);
        }
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
            'airplanes' => $this -> airplanes,
            'targetAirports' => $this -> targetAirports,
            'warning' => $warning
        ]);
    }
}