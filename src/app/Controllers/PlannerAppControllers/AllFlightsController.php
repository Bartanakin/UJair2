<?php

namespace App\Controllers\PlannerAppControllers;

use App\Entities\Flight;
use App\Interfaces\FindAllFlights;
use App\Interfaces\FindCrewForFlight;
use App\Interfaces\FlightEditorInterfaces\AvailableAirplaneFinder;
use App\Interfaces\FlightEditorInterfaces\FindFlightData;
use App\Interfaces\FlightEditorInterfaces\FlightCorrectnessChecker;
use App\Interfaces\FlightEditorInterfaces\FlightEditor;
use App\Interfaces\FlightEditorInterfaces\TargetAirportFinder;
use App\View;
use App\ViewPaths;

class AllFlightsController
{
    protected ?Flight $editedFlight;
    public function __construct(
        protected FindCrewForFlight $findCrewForFlight
    )
    {

    }

    public function editCrew(): View {
        // TODO
        return View::make(ViewPaths::EDIT_CREW_PAGE);
    }
    public function addFlight(): View{
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }
    public function editFlight(): View{
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }
    public function showSettlements(): View{
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }
}