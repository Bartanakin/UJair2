<?php

namespace App\Entities;

class Airplane
{
    protected function __construct(
        protected ?int $ID = null,
        protected ?string $typeName = null,
        protected ?AirplanePosition $position = null,
        protected ?Airport $currentAirport = null
    ){

    }

    public static function createForAllFlights(
        int $ID,
        string $typeName
    )
    {
        return new static(ID: $ID, typeName: $typeName );
    }

    public static function createForAvailableAirplanes(
        int    $airplaneID,
        string $airplaneTypeName,
        string $position,
        int    $airportID,
        string $airportName
    )
    {
        return new static(
            ID: $airplaneID,
            typeName: $airplaneTypeName,
            position: AirplanePosition::tryFrom($position),
            currentAirport: Airport::createForAvailableAirplanes($airportID,$airportName)
        );
    }

    public static function createForSelectAirplane(
        int    $airplaneID,
        string $airplaneTypeName
    )
    {
        return new static(
            ID: $airplaneID,
            typeName: $airplaneTypeName,
            position: AirplanePosition::FREE
        );
    }

    /**
     * @return int|null
     */
    public function getID(): ?int
    {
        return $this->ID;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function getCondition(): string
    {
        return $this -> position -> value;
    }

    public function getCurrentAirport(): Airport
    {
        return $this -> currentAirport;
    }

}