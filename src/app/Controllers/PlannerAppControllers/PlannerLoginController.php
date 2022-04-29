<?php

namespace App\Controllers\PlannerAppControllers;

use App\Exceptions\IncorrectLoginException;
use App\Exceptions\IncorrectPasswordException;
use App\Interfaces\PlannerLoginInterface;
use App\View;
use App\ViewPaths;

class PlannerLoginController
{
    public function __construct(protected PlannerLoginInterface $loginService){

    }
    public function login(): View {
        if( isset($_POST["login"],$_POST["password"])){
            $login = $_POST["login"];
            $password = $_POST["password"];
            try{
                $this -> loginService -> login($login,$password);
                $_SESSION["logged"] = true;
                return View::make(ViewPaths::ALL_FLIGHTS_PAGE);
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