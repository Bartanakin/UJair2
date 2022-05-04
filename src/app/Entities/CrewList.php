<?php

namespace App\Entities;

use App\Entities\PersonClasses\Pilot;

class CrewList
{
    protected function __construct(
        protected ?int $maxNumberOfFA = null,
        protected array $flightAttendants = [],
        protected ?Pilot $captain = null,
        protected ?Pilot $firstOfficer = null
    )
    {

    }

    public static function createForFindCrew(
        int $maxNumberOfFA,
        array $flightAttendants,
        ?Pilot $captain,
        ?Pilot $firstOfficer
    ): static {
        return new static(
            maxNumberOfFA: $maxNumberOfFA,
            flightAttendants: $flightAttendants,
            captain: $captain,
            firstOfficer: $firstOfficer
        );
    }
}