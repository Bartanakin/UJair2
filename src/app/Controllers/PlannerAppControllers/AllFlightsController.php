<?php

namespace App\Controllers\PlannerAppControllers;

use App\Interfaces\FindCrewForFlight;
use App\View;
use App\ViewPaths;

class AllFlightsController
{
    public function __construct(
        protected FindCrewForFlight $findCrewForFlight
    )
    {
    }

    public function addFlight(): View{
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }

    public function editFlight(): View{
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }

    public function editCrew(): View{
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }

    public function showSettlements(): View{
        // TODO
        return View::make(ViewPaths::EDIT_FLIGHT_PAGE);
    }
}