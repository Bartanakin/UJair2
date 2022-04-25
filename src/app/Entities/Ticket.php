<?php

namespace App\Entities;

use JsonSerializable;

class Ticket implements JsonSerializable {
    public function __construct(protected int $id, protected int $flightID, protected int $numberOfSeat, protected int $passengerID) {

    }

    public function jsonSerialize(): array {
        return [
            'ID' => $this->id,
            'FlightID' => $this->flightID,
            'NumberOfSeat' => $this->numberOfSeat,
            'PassengerID' => $this->passengerID
        ];
    }
}