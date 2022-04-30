<?php

namespace App\Controllers\PlannerAppControllers;

use App\Exceptions\IncorrectLoginException;
use App\Exceptions\IncorrectPasswordException;
use App\Interfaces\FindAllFlights;
use App\Interfaces\PlannerLoginInterface;
use App\View;
use App\ViewPaths;

class PlannerLoginController
{
    public function __construct(
        protected PlannerLoginInterface $loginService,
        protected FindAllFlights $findAllFlights
    ){

    }
    public function login(): View {
        if( isset($_POST["login"],$_POST["password"])){
            try{
                $this -> loginService -> login($_POST["login"],$_POST["password"]);
                $_SESSION["logged"] = true;
                return View::make(ViewPaths::ALL_FLIGHTS_PAGE,[$this -> findAllFlights -> findAllFlights()]);
            }
            catch( IncorrectLoginException|IncorrectPasswordException $e ){
                return View::make(ViewPaths::HOME_PAGE,['serverMessage' => ($e -> getMessage())]);
            }
        }
        else {
            return View::make(ViewPaths::BAD_REQUEST);
        }
    }
}