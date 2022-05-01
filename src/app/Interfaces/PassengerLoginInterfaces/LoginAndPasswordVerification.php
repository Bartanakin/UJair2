<?php

namespace App\Interfaces\PassengerLoginInterfaces;

interface LoginAndPasswordVerification {
    function run(string $login, string $password) : int;
}

