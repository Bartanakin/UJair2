<?php

namespace App\Interfaces\PassengerRegistrationInterfaces;

interface LoginChecker {
    function run(string $login) : bool;
}