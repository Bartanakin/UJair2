<?php

namespace App\Entities\PersonClasses;

class Pilot extends Employee
{
    protected function __construct(
        ?int $ID = null,
        ?string $firstName = null,
        ?string $surname = null,
        ?\DateTime $dateOfEmployment = null,
        protected ?EmployeeDegree $degree = null
    )
    {
        parent::__construct($ID,$firstName,$surname,$dateOfEmployment);
    }

    public static function createForFindCrew(
        int $ID,
        string $firstName,
        string $Surname,
        string $degreeString
    ): static {
        return new static(
            ID: $ID,
            firstName: $firstName,
            surname: $Surname,
            degree: EmployeeDegree::tryFrom($degreeString)
        );
    }

    function getDegree(): EmployeeDegree {
        return $this -> degree ?? EmployeeDegree::UNDEFINED;
    }
}