<?php

namespace App\Interfaces\BookingTicketsInterfaces;

use App\Entities\Ticket;

interface InsertionNewTicket
{
    function run(Ticket $ticket): bool;
}