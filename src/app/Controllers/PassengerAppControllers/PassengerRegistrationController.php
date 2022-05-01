<?php

namespace App\Controllers\PassengerAppControllers;

use App\Interfaces\PassengerRegistrationInterfaces\CountriesLoader;
use App\Interfaces\PassengerRegistrationInterfaces\LoginChecker;

class PassengerRegistrationController
{
    public function __construct(protected LoginChecker $loginChecker,
                                protected CountriesLoader $countriesLoader)
    {
    }

    public function canAddLogin() {
        $login = $_GET['login'];
        echo json_encode(['answer' => $this -> loginChecker -> run($login)]);
    }

    public function loadCountries() {
        echo json_encode($this -> countriesLoader -> run());
    }
}