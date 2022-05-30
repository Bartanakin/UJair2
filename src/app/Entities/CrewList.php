<?php

namespace App\Entities;

use App\Entities\PersonClasses\Employee;
use App\Entities\PersonClasses\EmployeeDegree;
use App\Entities\PersonClasses\Pilot;
use JetBrains\PhpStorm\Internal\TentativeType;

class CrewList
{
    protected $iter = -2;
    protected function __construct(
        protected ?int $maxNumberOfFA = null,
        protected array $flightAttendants = [],
        protected ?Pilot $captain = null,
        protected ?Pilot $firstOfficer = null
    )
    {

    }

    public static function createForFindCrew(
        int $maxNumberOfFA,
        array $flightAttendants,
        ?Pilot $captain,
        ?Pilot $firstOfficer
    ): static {
        return new static(
            maxNumberOfFA: $maxNumberOfFA,
            flightAttendants: $flightAttendants,
            captain: $captain,
            firstOfficer: $firstOfficer
        );
    }

    public function findEmployee(int $ID): ?Employee {
        $a = array_merge([$this -> captain,$this -> firstOfficer], $this -> flightAttendants);
        $empPos = array_search($ID, array_map(fn($s) => $s ?-> getID(), $a));
        return $empPos === false ? null : $a[$empPos];
    }

    public function getEmployers(): array {
        $a = [];
        if( $this -> captain ) $a[] = $this -> captain;
        if( $this -> firstOfficer ) $a[] = $this -> firstOfficer;
        return array_merge($a,$this -> flightAttendants);
    }

    /**
     * @return array
     */
    public function getFlightAttendants(): array
    {
        return $this->flightAttendants;
    }

    /**
     * @return Pilot|null
     */
    public function getCaptain(): ?Pilot
    {
        return $this->captain;
    }

    /**
     * @return Pilot|null
     */
    public function getFirstOfficer(): ?Pilot
    {
        return $this->firstOfficer;
    }

    /**
     * @return int|null
     */
    public function getMaxNumberOfFA(): ?int
    {
        return $this->maxNumberOfFA;
    }

    public function isFull(): bool {
        return $this -> maxNumberOfFA <= count($this -> flightAttendants);
    }

    public function getSlot(int $getID): EmployeeDegree
    {
        if( $this -> captain ?-> getID() ===$getID) return EmployeeDegree::CAPTAIN;
        else if( $this -> firstOfficer ?-> getID() ===$getID) return EmployeeDegree::FIRST_OFFICER;
        else  return EmployeeDegree::FLIGHT_ATTENDANT;
    }

}