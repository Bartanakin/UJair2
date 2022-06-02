<?php

namespace App\Controllers\PassengerAppControllers;

use App\Entities\PersonClasses\Passenger;
use App\Interfaces\PassengerRegistrationInterfaces\CountriesLoader;
use App\Interfaces\PassengerRegistrationInterfaces\InsertionNewPassenger;
use App\Interfaces\PassengerRegistrationInterfaces\LoginChecker;
use App\View;
use App\ViewPaths;

class PassengerRegistrationController
{
    public function __construct(
        protected CountriesLoader $countriesLoader,
        protected InsertionNewPassenger $insertPassenger
    )
    {
    }

    public function loadCountries() {
        $token = $_POST['token'];
        if($token == hash("sha256", "UJAIR2")) {
            return json_encode($this->countriesLoader->run());
        }else {
            return View::make( ViewPaths::UNAUTHORIZED);
        }
    }

    public function insertPassenger() {
        $passenger = Passenger::createPassengerForRegistration(
            $_POST['firstN'],
            $_POST['lastN'],
            $_POST['password'],
            $_POST['login'],
            $_POST['countryID']
        );
        $token = $_POST['token'];
        if($token == hash("sha256", "UJAIR2")) {
            return json_encode(['answer' => $this->insertPassenger->run($passenger)]);
        }else {
            return View::make( ViewPaths::UNAUTHORIZED);
        }
    }
}