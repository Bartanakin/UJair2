<?php

namespace Tests\Unit\Controllers;

use App\Controllers\PlannerAppControllers\flightEditorController;
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

        $this -> flightEditorController = new FlightEditorController(
            $this -> findFlightDataMock,
            $this -> availableAirplaneFinderMock,
            $this -> targetAirportFinderMock,
            $this -> flightEditorMock,
            $this -> flightCorrectnessCheckerMock,
            $this -> findAllFlights
        );
    }

    /** @test */
    public function checks_if_redirects_when_session_expired(){
        unset($_SESSION['editedFlight']);

        $expected = ViewPaths::SESSION_EXPIRED;

        $this -> assertEquals($expected, $this -> flightEditorController -> deleteFlight() -> getPath());
        $this -> assertEquals($expected, $this -> flightEditorController -> loadFlight() -> getPath());
        $this -> assertEquals($expected, $this -> flightEditorController -> selectDate() -> getPath());
        $this -> assertEquals($expected, $this -> flightEditorController -> selectAirplane() -> getPath());
        $this -> assertEquals($expected, $this -> flightEditorController -> selectTargetAirportTicketPriceAndConfirm() -> getPath());
        $this -> assertEquals($expected, $this -> flightEditorController -> acceptConfirmation() -> getPath());

    }

    /** @test */
    public function checks_if_methods_are_called_when_flight_is_about_to_be_edited(){
        $id = 1;
        $dateOfDeparture = '2022-06-06 00:00:00';
        $_SESSION['flight'] = Flight::createForAllFlights(
            $id,
            'X',
            'Y',
            $dateOfDeparture,
            '2022-06-06 08:00:00',
            1,
            'Boeing 737 Max',
            100,
            null
        );

        $this -> findFlightDataMock
            -> expects($this -> once())
            -> method('findFlightData')
            -> with($id);
        $this -> availableAirplaneFinderMock
            -> expects($this -> once())
            -> method('run')
            -> with(\DateTime::createFromFormat(Model::$dateFormat,$dateOfDeparture));
        $this -> targetAirportFinderMock
            -> expects(($this -> once()))
            -> method('run');

        $this -> assertEquals(ViewPaths::EDIT_FLIGHT_PAGE,$this -> flightEditorController -> loadFlight() -> getPath() );
    }

    /** @test */
    public function check_picking_a_date(){

        $_POST['pickedDate'] = '2022-06-06 00:00:00';

        $this -> availableAirplaneFinderMock
            -> expects($this -> once())
            -> method('run')
            -> with(\DateTime::createFromFormat(Model::$dateFormat,$_POST['pickedDate']));


        $this -> assertEquals(ViewPaths::EDIT_FLIGHT_PAGE,$this -> flightEditorController -> selectDate() -> getPath() );

    }

    /** @test */
    public function checks_picking_an_airplane(){

        $_POST['pickedAirplaneID'] = 1;

        $this -> targetAirportFinderMock
            -> expects($this -> once())
            -> method('run');


        $this -> assertEquals(ViewPaths::EDIT_FLIGHT_PAGE,$this -> flightEditorController -> selectAirplane() -> getPath() );

    }
    /** @test */
    public function check_picking_target_airport_price_and_inserting(){

        $_POST['pickedTargetAirportID'] = 1;
        $_POST['pickedTicketPrice'] = 100;
        $this -> flightEditorController -> setEditedFlightID(null);
        $this -> flightEditorMock
            -> expects($this -> once())
            -> method('insertFlight');


        $this -> assertEquals(
            ViewPaths::ALL_FLIGHTS_PAGE,
            $this -> flightEditorController -> selectTargetAirportTicketPriceAndConfirm() -> getPath()
        );

    }
    /** @test */
    public function check_picking_target_airport_price_and_edit_without_confirmation(){

        $_POST['pickedTargetAirportID'] = 1;
        $_POST['pickedTicketPrice'] = 100;
        $this -> flightEditorController -> setEditedFlightID(1);
        $this -> flightCorrectnessCheckerMock
            -> method('checkFlightEdit')
            -> willReturn(true);


        $this -> flightEditorMock
            -> expects($this -> once())
            -> method('editFlight');
        $this -> assertEquals(
            ViewPaths::ALL_FLIGHTS_PAGE,
            $this -> flightEditorController -> selectTargetAirportTicketPriceAndConfirm() -> getPath()
        );

    }
    /** @test */
    public function check_picking_target_airport_price_and_edit_with_confirmation(){

        $_POST['pickedTargetAirportID'] = 1;
        $_POST['pickedTicketPrice'] = 100;
        $this -> flightEditorController -> setEditedFlightID(1);
        $this -> flightCorrectnessCheckerMock
            -> method('checkFlightEdit')
            -> willReturn(false);

        $returnedView = $this -> flightEditorController -> selectTargetAirportTicketPriceAndConfirm();
        $this -> assertEquals(
            ViewPaths::CONFIRMATION_PAGE,
            $returnedView -> getPath()
        );
        $this -> assertEquals(
            'edit',
            $returnedView -> getParams()['editAction']
        );
    }
    /** @test */
    public function check_picking_target_airport_price_and_delete_with_confirmation(){

        $_POST['pickedTargetAirportID'] = 1;
        $_POST['pickedTicketPrice'] = 100;
        $this -> flightEditorController -> setEditedFlightID(1);
        $this -> flightCorrectnessCheckerMock
            -> method('checkFlightEdit')
            -> willReturn(false);

        $returnedView = $this -> flightEditorController -> selectTargetAirportTicketPriceAndConfirm();
        $this -> assertEquals(
            ViewPaths::CONFIRMATION_PAGE,
            $returnedView -> getPath()
        );
        $this -> assertEquals(
            'delete',
            $returnedView -> getParams()['editAction']
        );
    }
    /** @test */
    public function check_delete_after_confirmation(){

        $_POST['pickedTargetAirportID'] = 1;
        $_POST['pickedTicketPrice'] = 100;
        $this -> flightEditorController -> setEditedFlightID(1);
        $this -> flightCorrectnessCheckerMock
            -> method('checkFlightEdit')
            -> willReturn(false);

        $returnedView = $this -> flightEditorController -> selectTargetAirportTicketPriceAndConfirm();
        $this -> assertEquals(
            ViewPaths::CONFIRMATION_PAGE,
            $returnedView -> getPath()
        );
        $this -> assertEquals(
            'delete',
            $returnedView -> getParams()['editAction']
        );
    }
    /** @test */
    public function check_confirmation_positive_decision(){
        $_POST['decision'] = true;
        $returnedView = $this -> flightEditorController -> acceptConfirmation();

        $this -> findAllFlights
            -> expects($this -> once())
            -> method('findAllFlights');

        $this -> assertEquals(
            ViewPaths::ALL_FLIGHTS_PAGE,
            $returnedView -> getPath()
        );
        $this -> assertEquals(
            'A flight has been edited',
            $returnedView -> getParams()['message']
        );
    }
    /** @test */
    public function check_confirmation_negative_decision(){
        $_POST['decision'] = false;

        $returnedView = $this -> flightEditorController -> acceptConfirmation();

        $this -> findFlightDataMock
            -> expects($this -> once())
            -> method('findFlightData');
        $this -> assertEquals(
            ViewPaths::EDIT_FLIGHT_PAGE,
            $returnedView -> getPath()
        );
    }
    /** @test */
    public function check_cancel(){

        $this -> findAllFlights
            -> expects($this -> once())
            -> method('findAllFlights');
        $returnedView = $this -> flightEditorController -> cancel();

        $this -> assertEquals(
            ViewPaths::ALL_FLIGHTS_PAGE,
            $returnedView -> getPath()
        );
    }
    /** @test */
    public function check_picking_invalid_ticket_price(){
        $_POST['pickedTargetAirportID'] = 1;
        $_POST['pickedTicketPrice'] = -100;

        $returnedView = $this -> flightEditorController -> selectTargetAirportTicketPriceAndConfirm();

        $this -> assertEquals(
            ViewPaths::EDIT_FLIGHT_PAGE,
            $returnedView -> getPath()
        );
        $this -> assertEquals(
            "Given price is incorrect.",
            $returnedView -> getParams()['priceErrorMessage']
        );

    }
}