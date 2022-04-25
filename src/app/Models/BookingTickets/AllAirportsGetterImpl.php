<?php

namespace App\Models\BookingTickets;

use App\Entities\Airport;

class AllAirportsGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter {

    public function __construct(protected array $airports = []){
        parent::__construct();
    }
    function run(): array {
        $query = 'SELECT Airports.ID, Airports.Airport_name FROM Airports;';
        $statement = $this -> dbConnection -> prepare($query);
        $statement -> execute();
        while($data = $statement -> fetch()) {
            $this -> airports[] = new Airport($data['ID'], $data['Airport_name']);
        }
        return $this -> airports;
    }
}