<?php

namespace App\Models\BookingTicketsModels;

use App\DataBaseConnection;
use App\Entities\Ticket;

class InsertionNewTicketImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\InsertionNewTicket
{
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct($dataBaseConnection);
    }

    function run(Ticket $ticket): int
    {
        $query = 'INSERT INTO Tickets VALUES
            (NULL, ?, ?, ?)';

        $statement = $this -> getDBConnection() -> prepare($query);
        try {
            $this -> getDBConnection() -> beginTransaction();
            $success = $statement->execute([$ticket -> flightID, $ticket -> numberOfSeat, $ticket -> passengerID]);
            $this -> getDBConnection() -> commit();
        } catch(\PDOException $error) {
            $this -> getDBConnection() -> rollBack();
            $success = false;
        }
        return (int)$success;
    }
}
