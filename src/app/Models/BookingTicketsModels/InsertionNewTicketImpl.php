<?php

namespace App\Models\BookingTicketsModels;

use App\DataBaseConnection;

class InsertionNewTicketImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\InsertionNewTicket
{
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct($dataBaseConnection);
    }

    function run(int $flightID, int $seat, int $passengerID): bool
    {
        $query = 'INSERT INTO Tickets VALUES
            (NULL, ?, ?, ?)';

        $statement = $this -> getDBConnection() -> prepare($query);
        try {
            $this -> getDBConnection() -> beginTransaction();
            $success = $statement->execute([$flightID, $seat, $passengerID]);
            $this -> getDBConnection() -> commit();
        } catch(\PDOException $error) {
            $this -> getDBConnection() -> rollBack();
            $success = false;
        }
        return $success;
    }
}