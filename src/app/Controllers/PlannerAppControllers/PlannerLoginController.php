<?php

namespace App\Controllers\PlannerAppControllers;

use App\C\Controller;
use App\Exceptions\IncorrectLoginException;
use App\Exceptions\IncorrectPasswordException;
use App\Interfaces\FindAllFlights;
use App\Interfaces\PlannerLoginInterface;
use App\View;
use App\ViewPaths;
use function PHPUnit\Framework\isEmpty;

class PlannerLoginController extends Controller
{
    public function __construct(
        protected PlannerLoginInterface $loginService,
        protected FindAllFlights $findAllFlights
    ){
        parent::__construct();
    }
    public function login(): View {
        if( $this -> logged )
            return $this -> makeAllFlightsView();
        if( isset($_POST["login"],$_POST["password"])){
            try{
                $this -> loginService -> login($_POST["login"],$_POST["password"]);
                $this -> logged = true;
                return $this -> makeAllFlightsView();
            }
            catch( IncorrectLoginException|IncorrectPasswordException $e ){
                return View::make(ViewPaths::HOME_PAGE,['serverMessage' => ($e -> getMessage())]);
            }
        }
        return View::make(ViewPaths::BAD_REQUEST);
    }

    private function makeAllFlightsView(): View
    {
        return View::make(
            ViewPaths::ALL_FLIGHTS_PAGE,
            ['allFLights' => $this -> findAllFlights -> findAllFlights()]
        );
    }

}