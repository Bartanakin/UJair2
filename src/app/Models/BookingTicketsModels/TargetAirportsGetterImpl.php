<?php

namespace App\Models\BookingTicketsModels;

use App\DataBaseConnection;
use App\Entities\Airport;

class TargetAirportsGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\TargetAirportsGetter
{

    protected array $airports = [];
    public function __construct( DataBaseConnection $dataBaseConnection){
        parent::__construct($dataBaseConnection);
    }

    function run(int $start): array
    {
        $query = 'SELECT R.TargetAirportID AS ID, A.Airport_name, Countries.CountryName FROM Routes AS R
                  JOIN Airports AS A ON A.ID = R.TargetAirportID
                  JOIN Countries ON A.CountryID = Countries.ID
                    WHERE R.StartingAirportID = ?;';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute([$start]);
        while($data = $statement -> fetch()) {
            $this->airports[] = Airport::createForBookingtickets($data['ID'], $data['Airport_name'], $data['CountryName']);
//            echo $data['ID'] . " " . $data['Airport_name'] . '<br/ >';
        }
        return $this -> airports;
    }
}