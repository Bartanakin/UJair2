<?php

namespace App\Controllers\PassengerAppControllers;

use App\Interfaces\PassengerRegistrationInterfaces\LoginChecker;

class PassengerRegistrationController
{
    public function __construct(protected LoginChecker $loginChecker)
    {
    }

    public function canAddLogin() {
        $login = $_GET['login'];
        echo json_encode(['answer' => $this -> loginChecker -> run($login)]);
    }
}