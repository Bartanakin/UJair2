<?php

namespace App\Controllers;

use App\Interfaces\PlannerLoginInterface;
use App\View;
use App\ViewPaths;
use App\Views\BadRequestView;
use App\Views\HomeView;

class PlannerLoginController
{
    public function __construct(protected PlannerLoginInterface $loginService){

    }
    public function login(){
        if( isset($_POST["login"],$_POST["password"])){
            $login = $_POST["login"];
            $password = $_POST["password"];
            if( $this -> loginService -> login($login,$password) ){

            }
            else{
                View::make(ViewPaths::HOME_PAGE->value);
            }

        }
        else {
            View::make(ViewPaths::BAD_REQUEST ->value);
        }

    }
}