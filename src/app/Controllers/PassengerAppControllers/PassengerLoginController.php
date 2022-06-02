<?php

namespace App\Controllers\PassengerAppControllers;

use App\C\Controller;
use App\Interfaces\PassengerLoginInterfaces\LoginAndPasswordVerification;
use App\View;
use App\ViewPaths;

class PassengerLoginController extends Controller
{
    public function __construct(LoginAndPasswordVerification $verification)
    {
        parent::__construct($verification);
    }

    public function getPassengerIDIfExists() {
        $login = $_POST['login'];
        $password = $_POST['hashP'];
        if($this->verifyAccount()) {
            return json_encode(["passengerID" => $this->loginAndPasswordVerification->run($login, $password)]);
        }else {
            return $this->createUnauthorizedView();
        }
    }
}