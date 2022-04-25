<?php

namespace App\Models\BookingTickets;

use App\Entities\Ticket;

class InsertionNewTicketImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\InsertionNewTicket
{
    public function __construct(){
        parent::__construct();
    }

    function run(Ticket $ticket): bool
    {
        // TODO: Implement run() method.
    }
}