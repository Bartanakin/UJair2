<?php

namespace App\Entities;

use App\Entities\PersonClasses\Employee;
use App\Exceptions\SessionExpiredException;
use App\Exceptions\TicketPriceNotPositiveNumberException;
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
        protected ?CrewList $crewList = null,
        protected float $price = 0,
        protected string $warning = ""
    ) {

    }

    public static function createForBookingTickets(
        int $id,
        string $date,
        float $price
    ) {
        return new static(
            id: $id,
            dateOfDeparture: DateTime::createFromFormat(Model::$dateFormat, $date),
            price: $price
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

    public static function createForFlightDataFinderForCrewEditionImpl(int $flightID, DateTime $dateTimeOfDeparture)
    {
        return new static(
            ID: $flightID,
            dateOfDeparture: $dateTimeOfDeparture
        );
    }


    public function jsonSerialize(): mixed {
        return [
            'ID' => $this->id,
            'DateTimeOfDeparture' => $this->dateOfDeparture->format('Y-m-d H:i'),
            'Price' => $this->price
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

    public function unsetToDate(DateTime $date)
    {
        $this -> startingAirport = null;
        $this -> targetAirport = null;
        $this -> dateOfDeparture = $date;
        $this -> estimatedArrivalTime = null;
        $this -> airplane = null;
        $this -> price = 0;
        $this -> warning = "";
    }

    public function assertDate(): void
    {
        if($this -> dateOfDeparture === null)
            throw new SessionExpiredException("Null date detected while adding flight.");
    }

    public function assertAirplaneAndDateForEditFlight()
    {
        $this -> assertDate();
        if($this -> airplane === null
            || $this ?-> airplane -> getID() === null
            || $this ?-> airplane -> getTypeName() === null
            || $this -> startingAirport === null
            || $this ?-> startingAirport -> getID() === null
            || $this ?-> startingAirport -> getAirportName() === null
        ){
            throw new SessionExpiredException("Null airplane or its components detected.");
        }
    }

    public function unsetToAirplane(
        int $airplaneID,
        string $airplaneTypeName,
        int $startingAirportID,
        string $startingAirportName
    )
    {
        $this -> startingAirport = Airport::createForSelectAirplane($startingAirportID,$startingAirportName);
        $this -> targetAirport = null;
        $this -> estimatedArrivalTime = null;
        $this -> airplane = Airplane::createForSelectAirplane($airplaneID,$airplaneTypeName);
        $this -> price = 0;
        $this -> warning = "";
    }

    public function setTicketPrice(float $price)
    {
        if( $price <= 0 )
            throw new TicketPriceNotPositiveNumberException("Ticket price should be grater than 0.");
        $this -> price = $price;
    }

    public function setTargetAirport(Airport $targetAirport)
    {
        $this -> targetAirport = $targetAirport;
    }

    public function assertAirplaneAndDateAndTargetAirportForEditFlight()
    {
        $this -> assertAirplaneAndDateForEditFlight();
        if($this -> price === null
            || $this -> targetAirport === null
            || $this ?-> targetAirport -> getID() === null
            || $this ?-> targetAirport -> getAirportName() === null
        )
            throw new SessionExpiredException("Null target airport or price has been detected.");
    }

    public function setCrewList(CrewList $crewList)
    {
        $this -> crewList = $crewList;
    }

    public function assertCrewListWithEmployee(int $EmployeeID)
    {
        if($this -> crewList === null
            || $this -> crewList -> findEmployee($EmployeeID) === null
        )
            throw new SessionExpiredException("Improper crew list detected.");

    }

    /**
     * @return CrewList|null
     */
    public function getCrewList(): ?CrewList
    {
        return $this->crewList;
    }

    public function assertFlightID()
    {
        if( $this -> getId() === null )
            throw new SessionExpiredException("Flight id is null!");
    }

}