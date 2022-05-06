<?php

namespace App\Models;

use App\DataBaseConnection;

class FindAllFlightsImpl extends \App\Model implements \App\Interfaces\FindAllFlights
{

    public function __construct( DataBaseConnection $dataBaseConnection )
    {
        parent::__construct($dataBaseConnection);
    }

    public function findAllFlights(): array
    {
        $this -> dataBaseConnection -> getPDO() -> prepare('CALL findAllFlights()');
        return [];
    }
}