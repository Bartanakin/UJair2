<?php

namespace App\Interfaces\EditCrewInterfaces;

use App\Entities\PersonClasses\EmployeeDegree;

interface AvailableMemberFinder
{
    public function run(EmployeeDegree $degree): array;
}