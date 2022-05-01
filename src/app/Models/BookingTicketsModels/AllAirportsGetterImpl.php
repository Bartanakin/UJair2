<?php

namespace App\Models\BookingTicketsModels;

use App\DataBaseConnection;
use App\Entities\Airport;

class AllAirportsGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter {

    public function __construct( DataBaseConnection $dataBaseConnection,protected array $airports = []){
        parent::__construct($dataBaseConnection);
    }
    function run(): array {
        $query = 'SELECT Airports.ID, Airports.Airport_name FROM Airports;';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute();
        while($data = $statement -> fetch()) {
            $this -> airports[] = Airport::createForBookingtickets($data['ID'], $data['Airport_name']);
        }
        return $this -> airports;
    }
}