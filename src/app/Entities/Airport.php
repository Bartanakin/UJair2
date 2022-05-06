<?php

namespace App\Entities;

use JsonSerializable;

class Airport implements JsonSerializable{
    protected function __construct(
        protected ?int $id = null,
        protected ?string $airportName = null
    ) {

    }

    public function jsonSerialize(): array {
        return [
            'ID' => $this->id,
            'Airport_name' => $this->airportName
        ];
    }

    public static function createForBookingtickets(
        int $id,
        string $airportName
    ) {
        return new static(
            id: $id,
            airportName: $airportName
        );
    }

    public static function createForAllFlights(string $airportName){
        return new static(airportName: $airportName );
    }

    /**
     * @return string|null
     */
    public function getAirportName(): ?string
    {
        return $this->airportName;
    }
}