<?php

namespace App\Entities;

use JsonSerializable;

class Ticket implements JsonSerializable {
    protected function __construct(protected ?int $id = null,
                                protected ?int $flightID = null,
                                protected ?int $numberOfSeat = null,
                                protected ?int $passengerID = null) {

    }

    public function __get(string $name)
    {
        return $this -> $name;
    }

    public static function createForBookingTickets(int $flightID, int $numberOfSeat, int $passengerID) {
        return new static(
            flightID: $flightID,
            numberOfSeat: $numberOfSeat,
            passengerID: $passengerID
        );
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