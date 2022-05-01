<?php

namespace App\Models;

use App\DataBaseConnection;
use App\Entities\CrewList;
use App\Model;

class FindCrewForFlightImpl extends Model implements \App\Interfaces\FindCrewForFlight
{
    public function __construct(DataBaseConnection $dataBaseConnection)
    {
        parent::__construct($dataBaseConnection);
    }

    public function findCrewForFlight(): CrewList
    {
        return new CrewList();
    }
}