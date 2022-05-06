<?php

namespace App\Entities;

use App\Model;
use DateTime;
use JsonSerializable;

class Flight implements JsonSerializable {
    protected function __construct(
        protected ?int $id = null,
        protected ?Airport $startingAirport = null,
        protected ?Airport $targetAirport = null,
        protected ?DateTime $dateOfDeparture = null,
        protected ?DateTime $estimatedArrivalTime = null,
        protected ?Airplane $airplane = null,
        protected float $price = 0,
        protected string $warning = ""
    ) {

    }

    public static function createForBookingTickets(
        int $id,
        string $date
    ) {
        return new static(
            id: $id,
            dateOfDeparture: DateTime::createFromFormat(Model::$dateFormat, $date)
        );
    }

    public static function createForAllFlights(
        int $id,
        string $startingAirportName,
        string $targetAirportName,
        string $dateOfDeparture,
        int $airplaneId,
        string $airplaneTypeName,
        float $price
    ){
        return new static(
          id: $id,
          startingAirport: Airport::createForAllFlights($startingAirportName),
          targetAirport: Airport::createForAllFlights($targetAirportName) ,
          dateOfDeparture: DateTime::createFromFormat(Model::$dateFormat,$dateOfDeparture),
          airplane: Airplane::createForAllFlights($airplaneId,$airplaneTypeName),
          price: $price
        );
    }

    public static function createNull(): static
    {
        return new static();
    }

    public function jsonSerialize(): mixed {
        return [
            'ID' => $this->id,
            'DateTimeOfDeparture' => $this->dateOfDeparture->format(Model::$dateFormat)
        ];
    }

    public function __get(string $name)
    {
        if( property_exists(static::class,$name) ){
            return $this -> $name;
        }
        return null;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return DateTime|null
     */
    public function getDateOfDeparture(): ?DateTime
    {
        return $this->dateOfDeparture;
    }

    /**
     * @return Airplane|null
     */
    public function getAirplane(): ?Airplane
    {
        return $this->airplane;
    }

    /**
     * @return Airport|null
     */
    public function getStartingAirport(): ?Airport
    {
        return $this->startingAirport;
    }

    /**
     * @return Airport|null
     */
    public function getTargetAirport(): ?Airport
    {
        return $this->targetAirport;
    }

    /**
     * @param string $warning
     */
    public function setWarning(string $warning): void
    {
        $this->warning = $warning;
    }

    /**
     * @return float|int
     */
    public function getPrice(): float|int
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getWarning(): string
    {
        return $this->warning;
    }

}