<?php

namespace App\Controllers\PlannerAppControllers;

use App\C\Controller;
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

class FlightEditorController extends Controller
{
    protected ?Flight $editedFlight;
    protected ?array $airplanes;
    protected ?array $targetAirports;
    public function __construct(
        protected FindFlightData $findFlightData,
        protected AvailableAirplaneFinder $availableAirplaneFinder,
        protected TargetAirportFinder $targetAirportFinder,
        protected FlightEditor $flightEditor,
        protected FlightCorrectnessChecker $flightCorrectnessChecker,
        protected FindAllFlights $findAllFlights
    )
    {
        parent::__construct();

        $this -> trackSessionVariable('editedFlight','editedFlight',Flight::createNull());
        $this -> trackSessionVariable('airplanes','airplanes',[]);
        $this -> trackSessionVariable('targetAirports','targetAirports',[]);
    }


    public function addFlight(): View{
        if( ! $this -> logged ) return $this -> createSessionExpiredView();

        $this ->resetAllProps(['logged']);

        return $this -> createDefaultView();
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
        if( ! $this -> logged ) return $this -> createSessionExpiredView();

        return $this -> makeAllFlightsView("edition canceled");
    }

    public function cancelConfirmation(): View {
        if( ! $this -> logged ) return $this -> createSessionExpiredView();

        return $this->createDefaultView("Confirmation canceled");
    }

    public function loadFlight(): View{
        if( ! $this -> logged ) return $this -> createSessionExpiredView();
        if( $this -> assertPostVariables(['flightID']) ) return $this -> createBadRequestView();

        $this ->resetAllProps(['logged']);

        $this -> editedFlight -> setId($_POST['flightID']);
        return $this->createDefaultView();
    }

    public function selectDate(): View
    {
        if( ! $this -> logged ) return $this -> createSessionExpiredView();
        if( $this -> assertPostVariables(['date','hour','minute']) ) return $this -> createBadRequestView();

        try{
            $date = DateTime::createFromFormat('Y-m-j H:i',$_POST['date']." ".$_POST['hour'].":".$_POST['minute']);
            if( !$date ) throw new DateTimeException();
        }
        catch( DateTimeException $e ) {
            return $this -> createDefaultView("Incorrect date or time format");
        }
        $this -> airplanes = $this -> availableAirplaneFinder -> run($date);

        $this -> editedFlight -> unsetToDate($date);
        $this -> resetProp('targetAirports');


        return $this -> createDefaultView();
    }
    public function selectAirplane(): View
    {
        if( ! $this -> logged ) return $this -> createSessionExpiredView();
        if( $this -> assertPostVariables(['airplaneID','airplaneTypeName','startingAirportID','startingAirportName']) ) return $this -> createBadRequestView();

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
        if( ! $this -> logged ) return $this -> createSessionExpiredView();
        if( $this -> assertPostVariables(['ticketPrice','targetAirportID']) ) return $this -> createBadRequestView();

        try{
            [$targetAirportID,$targetAirportName] = explode('$',$_POST['targetAirportID']);

            if( !$targetAirportName || !$targetAirportID )
                throw new SessionExpiredException("Unable to find airport with id ". $targetAirportID);

            $this -> editedFlight -> setTicketPrice($_POST['ticketPrice']);
            $this -> editedFlight -> setTargetAirport(Airport::createTargetForConfirm( $targetAirportID,$targetAirportName));
            $this -> editedFlight -> assertAirplaneAndDateAndTargetAirportForEditFlight();

            if( $this -> editedFlight -> getId() === null ){
                $success = $this -> flightEditor -> insertFlight($this -> editedFlight);
                return $this -> makeAllFlightsView($success ? "New flight added" : "Adding flight unsuccessful");
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
        if( ! $this -> logged ) return $this -> createSessionExpiredView();
        return View::make(ViewPaths::CONFIRMATION_PAGE,['warning' => 'Are you sure you want to cancel this flight?','type' => 'delete']);
    }

    public function acceptConfirmation(): View
    {
        if( ! $this -> logged ) return $this -> createSessionExpiredView();
        if( $this -> assertPostVariables(['confirmationType']) ) return $this -> createBadRequestView();

        $success = false;
        if( $_POST['confirmationType'] == 'delete' )
            $success = $this -> flightEditor -> deleteFlight($this -> editedFlight);
        else if( $_POST['confirmationType'] == 'edit' )
            $success = $this -> flightEditor -> editFlight($this -> editedFlight);
        else
            return $this -> createBadRequestView();
        return $this->makeAllFlightsView($success ? "Flight edited" : "Edition unsuccessful");
    }

    private function createDefaultView($warning = ""):View{
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE, [
            'editedFlight' => $this -> editedFlight,
            'airplanes' => $this -> airplanes,
            'targetAirports' => $this -> targetAirports,
            'warning' => $warning
        ]);
    }

    private function makeAllFlightsView(string $message = ""): View
    {
        $this -> warning = $message;
        return View::make(ViewPaths::ALL_FLIGHT_REDIRECT);
    }
}