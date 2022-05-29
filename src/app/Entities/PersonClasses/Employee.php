<?php

namespace App\Entities\PersonClasses;

abstract class Employee extends Person
{
    protected function __construct(
        ?int $ID = null,
        ?string $firstName = null,
        ?string $surname = null,
        protected ?\DateTime $dateOfEmployment = null
    )
    {
        parent::__construct($ID,$firstName,$surname);
    }

    abstract function getDegree(): EmployeeDegree;
}