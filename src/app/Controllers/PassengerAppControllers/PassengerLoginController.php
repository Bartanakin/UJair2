<?php

namespace App\Controllers\PassengerAppControllers;

use App\Interfaces\PassengerLoginInterfaces\LoginAndPasswordVerification;

class PassengerLoginController
{
    public function __construct(protected LoginAndPasswordVerification $verification)
    {
    }

    public function getPassengerIDIfExists() {
        $login = $_GET['login'];
        $password = $_GET['password'];
        echo json_encode(["passengerID" => $this -> verification -> run($login, $password)]);
    }
}