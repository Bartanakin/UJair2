<?php

namespace App\Models\BookingTicketsModels;

use App\DataBaseConnection;
use App\Entities\Ticket;

class InsertionNewTicketImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\InsertionNewTicket
{
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct($dataBaseConnection);
    }

    function run(Ticket $ticket): bool
    {

    }
}