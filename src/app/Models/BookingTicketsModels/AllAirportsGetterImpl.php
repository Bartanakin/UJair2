<?php

namespace App\Models\BookingTicketsModels;

use App\DataBaseConnection;
use App\Entities\Airport;

class AllAirportsGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter {

    public function __construct( DataBaseConnection $dataBaseConnection,protected array $airports = []){
        parent::__construct($dataBaseConnection);
    }
    function run(): array {
        $query = 'SELECT COUNT(FD.StartingAirportName) AS StartingAirportName, FD.StartingAirportID AS ID, FD.StartingAirportName AS Airport_name, C.CountryName 
                  FROM FlightsData AS FD
                  JOIN Airports AS A ON A.ID = FD.StartingAirportID
                  JOIN Countries AS C ON C.ID = A.CountryID
                  GROUP BY FD.StartingAirportID, FD.StartingAirportName, C.CountryName;';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute();
        while($data = $statement -> fetch()) {
            $this -> airports[] = Airport::createForBookingtickets($data['ID'], $data['Airport_name'], $data['CountryName']);
        }
        return $this -> airports;
    }
}