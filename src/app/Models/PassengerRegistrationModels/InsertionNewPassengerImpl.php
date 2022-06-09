<?php

namespace App\Models\PassengerRegistrationModels;

use App\DataBaseConnection;
use App\Entities\PersonClasses\Passenger;

class InsertionNewPassengerImpl extends \App\Model implements \App\Interfaces\PassengerRegistrationInterfaces\InsertionNewPassenger
{
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct($dataBaseConnection);
    }

    function run(Passenger $passenger): int
    {
        $amountOfLogins = 0;
        $query = 'SELECT Count(*) AS amountOfLogins FROM Passengers WHERE ? LIKE Passengers.Login';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute([$passenger->getLogin()]);
        while($data = $statement -> fetch()) {
            $amountOfLogins = $data['amountOfLogins'];
        }
        if ($amountOfLogins != 0) {
            return -1;
        }
        $query = 'INSERT INTO Passengers VALUES
            (NULL, ?, ?, ?, ?, ?);';
        $statement = $this -> getDBConnection() -> prepare($query);
        try {
            $this->getDBConnection()->beginTransaction();
            $success = $statement->execute([
                $passenger->getFirstName(),
                $passenger->getSurname(),
                $passenger->getCountryID(),
                $passenger->getLogin(),
                $passenger->getPassword()
            ]);
            $this->getDBConnection()->commit();
        }
        catch(\PDOException $error) {
                $this -> getDBConnection() -> rollBack();
                $success = false;
        }



        return (int)$success;
    }
}