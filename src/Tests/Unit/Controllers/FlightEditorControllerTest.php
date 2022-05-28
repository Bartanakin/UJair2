<?php

namespace Tests\Unit\Controllers;

use App\Controllers\PlannerAppControllers\flightEditorController;
use App\Entities\Airplane;
use App\Entities\Airport;
use App\Entities\Flight;
use App\Interfaces\FindAllFlights;
use App\Interfaces\FlightEditorInterfaces\AvailableAirplaneFinder;
use App\Interfaces\FlightEditorInterfaces\FindFlightData;
use App\Interfaces\FlightEditorInterfaces\FlightCorrectnessChecker;
use App\Interfaces\FlightEditorInterfaces\FlightEditor;
use App\Interfaces\FlightEditorInterfaces\TargetAirportFinder;
use App\Model;
use App\ViewPaths;
use Cassandra\Date;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FlightEditorControllerTest extends TestCase
{

    private FlightEditorController $flightEditorController;
    private MockObject $findFlightDataMock;
    private MockObject $availableAirplaneFinderMock;
    private MockObject $targetAirportFinderMock;
    private MockObject $flightEditorMock;
    private MockObject $flightCorrectnessCheckerMock;
    private MockObject $findAllFlights;

    protected function setUp(): void
    {
        parent::setUp();
        $this -> findFlightDataMock = $this -> createMock(FindFlightData::class);
        $this -> availableAirplaneFinderMock = $this -> createMock(AvailableAirplaneFinder::class);
        $this -> targetAirportFinderMock = $this -> createMock(TargetAirportFinder::class);
        $this -> flightEditorMock = $this -> createMock(FlightEditor::class);
        $this -> flightCorrectnessCheckerMock = $this -> createMock(FlightCorrectnessChecker::class);
        $this -> findAllFlights = $this -> createMock(FindAllFlights::class);

    }

    private function make() {
        $this -> flightEditorController = new FlightEditorController(
            $this -> findFlightDataMock,
            $this -> availableAirplaneFinderMock,
            $this -> targetAirportFinderMock,
            $this -> flightEditorMock,
            $this -> flightCorrectnessCheckerMock,
            $this -> findAllFlights
        );
    }

//    /** @test */
//    public function checks_if_methods_are_called_when_flight_is_about_to_be_edited(){
//        $id = 1;
//        $dateOfDeparture = '2022-06-06 00:00:00';
//        $_SESSION['flight'] = Flight::createForAllFlights(
//            $id,
//            'X',
//            'Y',
//            $dateOfDeparture,
//            '2022-06-06 08:00:00',
//            1,
//            'Boeing 737 Max',
//            100,
//            null
//        );
//
//        $this -> findFlightDataMock
//            -> expects($this -> once())
//            -> method('findFlightData')
//            -> with($id);
//        $this -> availableAirplaneFinderMock
//            -> expects($this -> once())
//            -> method('run')
//            -> with(\DateTime::createFromFormat(Model::$dateFormat,$dateOfDeparture));
//        $this -> targetAirportFinderMock
//            -> expects(($this -> once()))
//            -> method('run');
//
//        $this -> assertEquals(ViewPaths::EDIT_FLIGHT_PAGE,$this -> flightEditorController -> loadFlight() -> getPath() );
//    }

    /** @test */
    public function check_picking_a_date(){
        $this -> make();

        $_POST['date'] = "2022-06-06";
        $_POST['hour'] = '00';
        $_POST['minute'] = '00';

        $this -> availableAirplaneFinderMock
            -> expects($this -> once())
            -> method('run')
            -> with(\DateTime::createFromFormat(Model::$dateFormat,'2022-06-06 00:00:00'));


        $this -> assertEquals(ViewPaths::EDIT_FLIGHT_PAGE,$this -> flightEditorController -> selectDate() -> getPath() );

    }

    /** @test */
    public function check_picking_target_airport_price_and_inserting(){
        $_SESSION['editedFlight'] = Flight::createNull();
        $_SESSION['editedFlight'] -> unsetToDate(\DateTime::createFromFormat(Model::$dateFormat,'2022-06-06 00:00:00'));
        $_SESSION['editedFlight'] -> unsetToAirplane(
            1,
            "Boeing 737 MAX",
            1,
            'X'
        );
        $_SESSION['airplanes'] = [ Airplane::createForSelectAirplane(1,"Boeing 737 MAX")];
        $_SESSION['targetAirports'] = [ Airport::createTargetForSelectAirplane(2,'X')];
        $this -> make();

        $_POST['targetAirportID'] = 2;
        $_POST['ticketPrice'] = 100;

        $this -> flightEditorMock
            -> expects($this -> once())
            -> method('insertFlight');


        $this -> assertEquals(
            ViewPaths::ALL_FLIGHTS_PAGE,
            $this -> flightEditorController -> selectTargetAirportTicketPriceAndConfirm() -> getPath()
        );

    }
//    /** @test */
//    public function check_picking_target_airport_price_and_edit_without_confirmation(){
//
//        $_POST['pickedTargetAirportID'] = 1;
//        $_POST['pickedTicketPrice'] = 100;
//        $this -> flightEditorController -> setEditedFlightID(1);
//        $this -> flightCorrectnessCheckerMock
//            -> method('checkFlightEdit')
//            -> willReturn(true);
//
//
//        $this -> flightEditorMock
//            -> expects($this -> once())
//            -> method('editFlight');
//        $this -> assertEquals(
//            ViewPaths::ALL_FLIGHTS_PAGE,
//            $this -> flightEditorController -> selectTargetAirportTicketPriceAndConfirm() -> getPath()
//        );
//
//    }
    /** @test */
    public function check_picking_target_airport_price_and_edit_with_confirmation(){
        $_SESSION['editedFlight'] = Flight::createNull();
        $_SESSION['editedFlight'] -> setId(1);
        $_SESSION['editedFlight'] -> unsetToDate(\DateTime::createFromFormat(Model::$dateFormat,'2022-06-06 00:00:00'));
        $_SESSION['editedFlight'] -> unsetToAirplane(
            1,
            "Boeing 737 MAX",
            1,
            'X'
        );
        $_SESSION['airplanes'] = [ Airplane::createForSelectAirplane(1,"Boeing 737 MAX")];
        $_SESSION['targetAirports'] = [ Airport::createTargetForSelectAirplane(2,'X')];

        $this -> make();

        $_POST['targetAirportID'] = 2;
        $_POST['ticketPrice'] = 100;


        $returnedView = $this -> flightEditorController -> selectTargetAirportTicketPriceAndConfirm();
        $this -> assertEquals(
            ViewPaths::CONFIRMATION_PAGE,
            $returnedView -> getPath()
        );
        $this -> assertEquals(
            'edit',
            $returnedView -> getParams()['type']
        );
    }
    /** @test */
    public function check_delete_flight(){
        $_SESSION['editedFlight'] = Flight::createNull();
        $_SESSION['editedFlight'] -> setId(1);
        $this -> make();

        $returnedView = $this -> flightEditorController -> deleteFlight();
        $this -> assertEquals(
            ViewPaths::CONFIRMATION_PAGE,
            $returnedView -> getPath()
        );
    }
    /** @test */
    public function check_delete_confirmation(){

        $_SESSION['editedFlight'] = Flight::createNull();
        $_SESSION['editedFlight'] -> setId(1);
        $this -> make();
        $_POST['confirmationType'] = 'delete';

        $returnedView = $this -> flightEditorController -> acceptConfirmation();
        $this -> assertEquals(
            ViewPaths::ALL_FLIGHTS_PAGE,
            $returnedView -> getPath()
        );
    }
    /** @test */
    public function check_delete_cancellation(){

        $_SESSION['editedFlight'] = Flight::createNull();
        $_SESSION['editedFlight'] -> setId(1);
        $this -> make();

        $returnedView = $this -> flightEditorController -> cancelConfirmation();

        $this -> assertEquals(
            ViewPaths::EDIT_FLIGHT_PAGE,
            $returnedView -> getPath()
        );
    }
    /** @test */
    public function check_cancel(){
        $this -> make();

        $this -> findAllFlights
            -> expects($this -> once())
            -> method('findAllFlights');
        $returnedView = $this -> flightEditorController -> cancel();

        $this -> assertEquals(
            ViewPaths::ALL_FLIGHTS_PAGE,
            $returnedView -> getPath()
        );
    }
}