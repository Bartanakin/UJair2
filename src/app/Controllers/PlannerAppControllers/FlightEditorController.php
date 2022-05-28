<?php

namespace App\Controllers\PlannerAppControllers;

use App\Entities\Airplane;
use App\Entities\Airport;
use App\Entities\Flight;
use App\Exceptions\SessionExpiredException;
use App\Exceptions\TicketPriceNotPositiveNumberException;
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
        return $this -> makeAllFlightsViewAndUnsetState("edition canceled");
    }

    public function cancelConfirmation(): View {
        return $this->createDefaultView("Confirmation canceled");
    }

    public function loadFlight(): View{
        if( !isset( $_POST['flightID']) )
            return View::make(ViewPaths::BAD_REQUEST);
        $this -> editedFlight -> setId($_POST['flightID']);
        return $this->createDefaultView();
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
        catch ( \PDOException $e ){
            return $this->createDefaultView('Invalid airplane data');
        }
        catch( SessionExpiredException $e ){
            return View::make(ViewPaths::SESSION_EXPIRED);
        }
        return $this -> createDefaultView();
    }

    public function selectTargetAirportTicketPriceAndConfirm(): View
    {
        if( !isset( $_POST['ticketPrice'], $_POST['targetAirportID'] ) )
            return View::make(ViewPaths::BAD_REQUEST);
        try{
            [$targetAirportID,$targetAirportName] = explode('$',$_POST['targetAirportID']);

            if( !$targetAirportName || !$targetAirportID )
                throw new SessionExpiredException("Unable to find airport with id ". $targetAirportID);

            $this -> editedFlight -> setTicketPrice($_POST['ticketPrice']);
            $this -> editedFlight -> setTargetAirport(Airport::createTargetForConfirm( $targetAirportID,$targetAirportName));
            $this -> editedFlight -> assertAirplaneAndDateAndTargetAirportForEditFlight();

            if( $this -> editedFlight -> getId() === null ){
                $success = $this -> flightEditor -> insertFlight($this -> editedFlight);
                return $this -> makeAllFlightsViewAndUnsetState($success ? "New flight added" : "Adding flight unsuccessful");
            }
            else{
                return View::make(ViewPaths::CONFIRMATION_PAGE,['warning' => 'Are you sure you want to edit this flight?','type' => 'edit']);
            }
        }catch( SessionExpiredException $e ){
            return View::make(ViewPaths::SESSION_EXPIRED);
        }catch ( TicketPriceNotPositiveNumberException $e ){
            return $this -> createDefaultView($e -> getMessage() );
        }
    }

    public function deleteFlight(): View
    {
        return View::make(ViewPaths::CONFIRMATION_PAGE,['warning' => 'Are you sure you want to cancel this flight?','type' => 'delete']);
    }

    public function acceptConfirmation(): View
    {
        if( !isset( $_POST['confirmationType']) )
            return View::make(ViewPaths::BAD_REQUEST);

        $success = false;
        if( $_POST['confirmationType'] == 'delete' )
            $success = $this -> flightEditor -> deleteFlight($this -> editedFlight);
        else if( $_POST['confirmationType'] == 'edit' )
            $success = $this -> flightEditor -> editFlight($this -> editedFlight);
        return $this->makeAllFlightsViewAndUnsetState($success ? "Flight edited" : "Edition unsuccessful");
    }

    private function createDefaultView($warning = ""):View{
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE, [
            'editedFlight' => $this -> editedFlight,
            'airplanes' => $this -> airplanes,
            'targetAirports' => $this -> targetAirports,
            'warning' => $warning
        ]);
    }

    private function makeAllFlightsViewAndUnsetState(string $message = ""): View
    {
        $this -> unsetState();
        return View::make(
            ViewPaths::ALL_FLIGHTS_PAGE,
            ['allFLights' => $this -> findAllFlights -> findAllFlights(),'message' => $message]
        );
    }

    private function unsetState(): void
    {
        $this->resetProp('editedFlight','editedFlight',Flight::createNull());
        $this->resetProp('airplanes','airplanes',[]);
        $this->resetProp('targetAirports','targetAirports',[]);
        $this->resetProp('warning','warning',"");
    }
}