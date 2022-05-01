<?php

namespace App\Entities;

use App\Model;
use DateTime;
use JsonSerializable;

class Ticket implements JsonSerializable {
    protected function __construct(protected ?int $id = null,
                                protected ?int $flightID = null,
                                protected ?int $numberOfSeat = null,
                                protected ?int $passengerID = null,
                                protected ?string $start = null,
                                protected ?string $target = null,
                                protected ?DateTime $dateOfDeparture = null) {

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

    public static function createForPassengersTickets(string $start, string $target, int $numberOfSeat, string $dateOfDeparture) {
        return new static(
            numberOfSeat: $numberOfSeat,
            start: $start,
            target: $target,
            dateOfDeparture: DateTime::createFromFormat(Model::$dateFormat, $dateOfDeparture)
        );
    }
    public function jsonSerialize(): array {
        return [
            'numberOfSeat' => $this->numberOfSeat,
            'start' => $this->start,
            'target' => $this->target,
            'dateOfDeparture' => date_format($this->dateOfDeparture, Model::$dateFormat)
        ];
    }
}