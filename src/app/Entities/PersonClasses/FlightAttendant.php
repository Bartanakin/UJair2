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