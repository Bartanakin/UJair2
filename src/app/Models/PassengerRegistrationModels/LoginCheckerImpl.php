<?php

namespace App\Models\PassengerRegistrationModels;

use App\DataBaseConnection;

class LoginCheckerImpl extends \App\Model implements \App\Interfaces\PassengerRegistrationInterfaces\LoginChecker
{

    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct($dataBaseConnection);
    }
    function run(string $login): bool
    {
        $amountOfLogins = 0;
        $query = 'SELECT Count(*) AS amountOfLogins FROM Passengers WHERE ? LIKE Passengers.Login';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute([$login]);
        while($data = $statement -> fetch()) {
            $amountOfLogins = $data['amountOfLogins'];
        }
        return $amountOfLogins == 0;
    }
}