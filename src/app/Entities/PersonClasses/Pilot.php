<?php

namespace App\Entities\PersonClasses;

class Pilot extends Employee
{
    protected function __construct(
        ?int $ID = null,
        ?string $firstName = null,
        ?string $surname = null,
        ?\DateTime $dateOfEmployment = null,
        protected ?EmployeeDegree $degree = null,
        protected ?int $timeOfFlight = 0
    )
    {
        parent::__construct($ID,$firstName,$surname,$dateOfEmployment);
    }

    public static function createForFindCrew(
        int $ID,
        string $fulName
    ): static {
        $names = explode(' ',$fulName);
        return new static(
            ID: $ID,
            firstName: $names[0],
            surname: $names[1]
        );
    }
}