<?php

namespace App\Models\BookingTickets;

use App\Entities\Airport;

class AllAirportsGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter {
    protected array $airports = [];
    public function __construct(){
        parent::__construct();
    }
    function run(): array {
        $query = 'SELECT Airports.ID, Airports.Airport_name FROM Airports;';
        $statement = $this -> dbConnection -> prepare($query);
        $statement -> execute();
        while($data = $statement -> fetch()) {
            $this->airports[] = new Airport($data['ID'], $data['Airport_name']);
//            echo $data['ID'] . " " . $data['Airport_name'] . '<br/ >';
        }
        return $this -> airports;
    }
}