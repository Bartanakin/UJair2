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
        $success = $this->verifyAccount();
        if($success == -1 || $success == 1) {
            return json_encode(["passengerID" => $this->loginAndPasswordVerification->run($login, $password)]);
        }else {
            return $this->createUnauthorizedView();
        }
    }
}