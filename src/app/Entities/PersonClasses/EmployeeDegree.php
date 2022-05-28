<?php

namespace App\Entities\PersonClasses;

enum EmployeeDegree: string
{
    case CAPTAIN = 'C';
    case FIRST_OFFICER = 'F';
    case FLIGHT_ATTENDANT = 'S';
    case UNDEFINED = 'U';
}