<?php

namespace App\Entities;

use JsonSerializable;

class Airport implements JsonSerializable{
    protected function __construct(
        protected ?int    $ID = null,
        protected ?string $airportName = null
    ) {

    }

    public static function createForAvailableAirplanes(
        int $airportID,
        string $airportName
    ): static
    {
        return new static(
            ID: $airportID,
            airportName: $airportName
        );
    }

    public function jsonSerialize(): array {
        return [
            'ID' => $this->ID,
            'Airport_name' => $this->airportName
        ];
    }

    public static function createForBookingtickets(
        int $id,
        string $airportName
    ) {
        return new static(
            ID: $id,
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