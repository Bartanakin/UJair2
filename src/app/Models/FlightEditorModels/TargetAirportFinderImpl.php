<?php

namespace App\Models\FlightEditorModels;

use App\DataBaseConnection;
use App\Entities\Airport;
use App\Entities\Flight;
use App\Model;

class TargetAirportFinderImpl extends Model implements \App\Interfaces\FlightEditorInterfaces\TargetAirportFinder
{
    public function __construct(DataBaseConnection $dataBaseConnection)
    {
        parent::__construct($dataBaseConnection);
    }

    private function findMaxDistance(Flight $editedFlight): float {
        $statement = $this -> getDBConnection() -> prepare(
            "SELECT AirplaneTypes.Max_distance as maxDistance
            FROM Airplanes JOIN AirplaneTypes ON Airplanes.AirplaneTypeID = AirplaneTypes.ID
            WHERE Airplanes.ID = ? LIMIT 1"
        );
        $statement -> execute([$editedFlight -> getId()]);
        return $statement -> fetch()['maxDistance'];
    }

    /**
     * @throws \App\Exceptions\SessionExpiredException
     */
    public function run(Flight $editedFlight): array
    {
        $editedFlight -> assertAirplaneAndDateForEditFlight();

        $maxDistance = $this -> findMaxDistance($editedFlight);

        $statement = $this -> getDBConnection() -> prepare("CALL FindAllTargetAirports(?,?)");
        $statement -> execute([$editedFlight -> getStartingAirport() -> getAirportName(), $maxDistance]);

        $airports = [];
        while( $row = $statement -> fetch() ){
            $airports[] = Airport::createTargetForSelectAirplane(
                $row['TargetAirportID'],
                $row['TargetAirportName']
            );
        }
        return $airports;
    }
}