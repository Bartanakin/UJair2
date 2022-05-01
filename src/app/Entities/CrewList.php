<?php

namespace App\Entities;

use App\Entities\PersonClasses\Pilot;

class CrewList
{
    // To be changed to protected
    public function __construct(
        protected ?int $maxNumberOfFA = null,
        protected ?array $flightAttendants = null,
        protected ?Pilot $captain = null,
        protected ?Pilot $firstOfficer = null
    )
    {

    }
}