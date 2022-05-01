<?php

namespace App\Controllers\PassengerAppControllers;

use App\Entities\PersonClasses\Passenger;
use App\Interfaces\PassengerRegistrationInterfaces\CountriesLoader;
use App\Interfaces\PassengerRegistrationInterfaces\InsertionNewPassenger;
use App\Interfaces\PassengerRegistrationInterfaces\LoginChecker;

class PassengerRegistrationController
{
    public function __construct(protected LoginChecker $loginChecker,
                                protected CountriesLoader $countriesLoader,
                                protected InsertionNewPassenger $insertPassenger)
    {
    }

    public function canAddLogin() {
        $login = $_GET['login'];
        echo json_encode(['answer' => $this -> loginChecker -> run($login)]);
    }

    public function loadCountries() {
        echo json_encode($this -> countriesLoader -> run());
    }

    public function insertPassenger() {
        $passenger = Passenger::createPassengerForRegistration($_GET['firstN'],
                                                                $_GET['lastN'],
                                                                $_GET['password'],
                                                                $_GET['login'],
                                                                $_GET['countryID']);
        echo json_encode(['answer' => $this -> insertPassenger -> run($passenger)]);
    }
}