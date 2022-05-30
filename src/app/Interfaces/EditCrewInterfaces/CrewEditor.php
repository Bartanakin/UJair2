<?php

namespace App\Interfaces\EditCrewInterfaces;

use App\Entities\PersonClasses\Employee;
use App\Entities\PersonClasses\EmployeeDegree;

interface CrewEditor
{
    public function linkMember(Employee $employee, EmployeeDegree $role, int $flightID): bool;
    public function unLinkMember(Employee $employee, int $flightID): bool;
}