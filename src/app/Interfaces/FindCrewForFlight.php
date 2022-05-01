<?php

namespace App\Interfaces;

use App\Entities\CrewList;

interface FindCrewForFlight
{
    public function findCrewForFlight(): CrewList;
}