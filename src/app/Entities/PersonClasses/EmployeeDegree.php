<?php

namespace App\Entities\PersonClasses;

enum EmployeeDegree: string
{
    case CAPTAIN = 'C';
    case FIRST_OFFICER = 'F';
    case FLIGHT_ATTENDANT = 'S';
    case UNDEFINED = 'U';

    public function getFullString(): string {
        return match ($this) {
            EmployeeDegree::CAPTAIN => 'Captain',
            EmployeeDegree::FIRST_OFFICER => 'First officer',
            EmployeeDegree::FLIGHT_ATTENDANT => 'Flight attendant',
            default => "",
        };
    }
}