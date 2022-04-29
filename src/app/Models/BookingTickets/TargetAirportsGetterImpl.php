<?php

namespace App\Models\BookingTickets;

use App\Entities\Airport;

class TargetAirportsGetterImpl extends \App\Model implements \App\Interfaces\BookingTicketsInterfaces\TargetAirportsGetter
{

    protected array $airports = [];
    public function __construct(){
        parent::__construct();
    }

    function run(int $start): array
    {
        $query = 'SELECT R.TargetAirportID AS ID, A.Airport_name FROM Routes AS R
            JOIN Airports AS A ON A.ID = R.TargetAirportID
            WHERE R.StartingAirportID = ?;';
        $statement = $this -> getDBConnection() -> prepare($query);
        $statement -> execute([$start]);
        while($data = $statement -> fetch()) {
            $this->airports[] = new Airport($data['ID'], $data['Airport_name']);
//            echo $data['ID'] . " " . $data['Airport_name'] . '<br/ >';
        }
        return $this -> airports;
    }
}