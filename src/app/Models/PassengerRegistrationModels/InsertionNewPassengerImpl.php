<?php

namespace App\Models\PassengerRegistrationModels;

use App\DataBaseConnection;
use App\Entities\PersonClasses\Passenger;

class InsertionNewPassengerImpl extends \App\Model implements \App\Interfaces\PassengerRegistrationInterfaces\InsertionNewPassenger
{
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct($dataBaseConnection);
    }

    function run(Passenger $passenger): bool
    {
        $query = 'INSERT INTO Passengers VALUES
            (NULL, ?, ?, ?, ?, ?);';
        $statement = $this -> getDBConnection() -> prepare($query);
        try {
            $this->getDBConnection()->beginTransaction();
            $success = $statement->execute([$passenger->firstName, $passenger->lastName, $passenger->countryID,
                $passenger->login, $passenger->password]);
            $this->getDBConnection()->commit();
        }
        catch(\PDOException $error) {
                $this -> getDBConnection() -> rollBack();
                $success = false;
        }
        return $success;
    }
}