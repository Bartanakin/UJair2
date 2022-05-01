<?php

namespace App\Models\PassengerLoginModels;

use App\DataBaseConnection;

class LoginAndPasswordVerificationImpl extends \App\Model implements \App\Interfaces\PassengerLoginInterfaces\LoginAndPasswordVerification
{
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct($dataBaseConnection);
    }

    function run(string $login, string $password): int
    {
        $passengerID = -1;
        $query = 'SELECT COUNT(*) AS ID, P.ID FROM Passengers AS P WHERE (P.Login LIKE ?) AND (P.Password LIKE ?) GROUP BY P.ID';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute([$login, $password]);
        while($data = $statement -> fetch()) {
            $passengerID = $data['ID'];
        }
        return $passengerID;
    }
}