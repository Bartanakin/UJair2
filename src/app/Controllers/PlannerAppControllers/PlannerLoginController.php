<?php

namespace App\Controllers\PlannerAppControllers;

use App\Exceptions\IncorrectLoginException;
use App\Exceptions\IncorrectPasswordException;
use App\Interfaces\FindAllFlights;
use App\Interfaces\PlannerLoginInterface;
use App\View;
use App\ViewPaths;
use function PHPUnit\Framework\isEmpty;

class PlannerLoginController
{
    public function __construct(
        protected PlannerLoginInterface $loginService,
        protected FindAllFlights $findAllFlights
    ){

    }
    public function login(): View {
        if( isset( $_SESSION['logged'])){
            if( $_SESSION['logged'] === true ){
                return $this -> makeAllFlightsView();
            }
        }
        if( isset($_POST["login"],$_POST["password"])){
            try{
                $this -> loginService -> login($_POST["login"],$_POST["password"]);
                $_SESSION["logged"] = true;
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