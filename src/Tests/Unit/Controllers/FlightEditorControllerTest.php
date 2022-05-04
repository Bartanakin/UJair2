<?php

namespace Tests\Unit\Controllers;

use App\Controllers\PlannerAppControllers\AllFlightsController;
use App\Entities\Flight;
use App\Interfaces\FindCrewForFlight;
use App\Interfaces\FlightEditorInterfaces\AvailableAirplaneFinder;
use App\Interfaces\FlightEditorInterfaces\FlightCorrectnessChecker;
use App\Interfaces\FlightEditorInterfaces\FlightEditor;
use App\Interfaces\FlightEditorInterfaces\TargetAirportFinder;
use App\ViewPaths;
use PHPUnit\Framework\TestCase;

class FlightEditorControllerTest extends TestCase
{

    private AllFlightsController $allFlightsController;
    private FindCrewForFlight $findCrewForFlight;
    private AvailableAirplaneFinder $availableAirplaneFinder;
    private TargetAirportFinder $targetAirportFinder;
    private FlightEditor $flightEditor;
    private FlightCorrectnessChecker $flightCorrectnessChecker;

    protected function setUp(): void
    {
        parent::setUp();
        $this -> allFlightsController = new AllFlightsController(
            $this -> createMock(FindCrewForFlight::class),
            $this -> createMock(AvailableAirplaneFinder::class),
            $this -> createMock(TargetAirportFinder::class),
            $this -> createMock(FlightEditor::class),
            $this -> createMock(FlightCorrectnessChecker::class)
        );
    }

    /** @test */
    public function checks_if_redirect_when_session_expired_when_flight_loads(){
        unset($_SESSION['flight']);

        $expected = ViewPaths::SESSION_EXPIRED;

        $this -> assertEquals($expected, $this -> allFlightsController -> loadFlight());

    }

    /** @test */
    public function checks_if_flight_is_decoded_properly(){
        $_SESSION['flight'] = Flight::createForAllFlights(
            1,
            'X',
            'Y',
            '2022-06-06 00:00:00',
            '2022-06-06 08:00:00',
            1,
            'Boeing 737 Max',
            100,
            null
        );

        $expected = ViewPaths::SESSION_EXPIRED;

        $this -> assertEquals($expected, $this -> allFlightsController -> loadFlight());

    }
}