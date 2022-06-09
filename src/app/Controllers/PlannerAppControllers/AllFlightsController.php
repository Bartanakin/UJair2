<?php

namespace App\Controllers\PlannerAppControllers;

use App\C\Controller;
use App\Container;
use App\Entities\Flight;
use App\Exceptions\IncorrectLoginException;
use App\Exceptions\IncorrectPasswordException;
use App\Interfaces\FindAllFlights;
use App\Interfaces\FindCrewForFlight;
use App\Interfaces\FlightEditorInterfaces\AvailableAirplaneFinder;
use App\Interfaces\FlightEditorInterfaces\FindFlightData;
use App\Interfaces\FlightEditorInterfaces\FlightCorrectnessChecker;
use App\Interfaces\FlightEditorInterfaces\FlightEditor;
use App\Interfaces\FlightEditorInterfaces\TargetAirportFinder;
use App\Interfaces\PlannerLoginInterface;
use App\View;
use App\ViewPaths;

class AllFlightsController extends Controller
{
    protected ?Flight $editedFlight;
    public function __construct(
        protected PlannerLoginInterface $loginService,
        protected FindAllFlights $findAllFlights
    )
    {
        parent::__construct();
    }


    public function login(): View {
        if( $this -> logged )
            return $this -> findAllFlights();
        if( isset($_POST["login"],$_POST["password"])){
            try{
                $this -> loginService -> login($_POST["login"],$_POST["password"]);
                $this -> logged = true;

                return $this -> findAllFlights();
            }
            catch( IncorrectLoginException|IncorrectPasswordException $e ){
                return View::make(ViewPaths::HOME_PAGE,['serverMessage' => ($e -> getMessage())]);
            }
        }
        return View::make(ViewPaths::BAD_REQUEST);
    }

    public function logout(): View{

        $this -> logged = false;
        return View::make(ViewPaths::ALL_FLIGHT_REDIRECT);
    }

    public function allFlights(): View {
        if( $this -> logged )
            return $this -> findAllFlights();
        else
            return View::make(ViewPaths::HOME_PAGE);
    }

    private function findAllFlights(): View
    {
        return View::make(
            ViewPaths::ALL_FLIGHTS_PAGE,
            ['allFLights' => $this -> findAllFlights -> findAllFlights(), 'warning' => $this->warning]
        );
    }
}