<?php

namespace App\Controllers\PassengerAppControllers;

use App\C\Controller;
use App\Interfaces\PassengerLoginInterfaces\LoginAndPasswordVerification;
use App\Interfaces\PassengersTicketsInterfaces\AllTicketsForPassengerGetter;

class PassengersTicketsController  extends Controller
{
    public function __construct(protected AllTicketsForPassengerGetter $allTicketsGetter,
                                LoginAndPasswordVerification $loginAndPasswordVerification) {
        parent::__construct($loginAndPasswordVerification);
    }

    public function getTicketsForPassengerID() {
        if($this -> verifyAccount()) {
            return json_encode($this->allTicketsGetter->run($_POST['passID']));
        }else {
            return $this->createUnauthorizedView();
        }
    }
}