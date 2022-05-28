<?php

namespace App\Entities\PersonClasses;

class FlightAttendant extends Employee
{
    protected function __construct(
        ?int $ID = null,
        ?string $firstName = null,
        ?string $surname = null,
        ?\DateTime $dateOfEmployment = null
    )
    {
        parent::__construct($ID,$firstName,$surname,$dateOfEmployment);
    }

    public static function createForFindCrew(
        int $ID,
        string $firstName,
        string $surname
    ): static {
        return new static(
            ID: $ID,
            firstName: $firstName,
            surname: $surname
        );
    }

    function getDegree(): EmployeeDegree
    {
        return EmployeeDegree::FLIGHT_ATTENDANT;
    }
}