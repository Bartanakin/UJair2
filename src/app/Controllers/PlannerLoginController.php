<?php

namespace App\Controllers;

use App\Interfaces\PlannerLoginInterface;
use App\View;
use App\ViewPaths;

class PlannerLoginController
{
    public function __construct(protected PlannerLoginInterface $loginService){

    }
    public function login(){
        if( isset($_POST["login"],$_POST["password"])){
            $login = $_POST["login"];
            $password = $_POST["password"];
            if( $this -> loginService -> login($login,$password) ){
                $_SESSION["logged"] = true;
                View::make(ViewPaths::ALL_FLIGHTS_PAGE);
            }
            else{
                View::make(ViewPaths::HOME_PAGE);
            }

        }
        else {
            View::make(ViewPaths::BAD_REQUEST);
        }

    }
}