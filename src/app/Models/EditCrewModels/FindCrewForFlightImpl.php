<?php

namespace App\Models\EditCrewModels;

use App\DataBaseConnection;
use App\Entities\CrewList;
use App\Model;

class FindCrewForFlightImpl extends Model implements \App\Interfaces\FindCrewForFlight
{
    public function __construct(DataBaseConnection $dataBaseConnection)
    {
        parent::__construct($dataBaseConnection);
    }

    private function findMaxNumberOfFA(int $flightID): int {
        return 0;
    }

    public function findCrewForFlight(int $flightID): CrewList {
        //return
    }
}