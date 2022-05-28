<?php

namespace App\Models\FlightEditorModels;

use App\DataBaseConnection;
use App\Entities\Airplane;
use App\Entities\Airport;
use App\Entities\Flight;
use App\Model;

class AvailableAirplaneFinderImpl extends Model implements \App\Interfaces\FlightEditorInterfaces\AvailableAirplaneFinder
{
    protected array $flights = [];
    public function __construct(DataBaseConnection $dataBaseConnection)
    {
        parent::__construct($dataBaseConnection);
    }

    public function run(\DateTime $date): array
    {

        $statement = $this -> getDBConnection() -> prepare("CALL FindAllAirplanes(?);");
        $statement->execute([$date->format(Model::$dateFormat)]);
        while( $result = $statement -> fetch() ){
            $this -> flights[] = Airplane::createForAvailableAirplanes(
                $result['AirplaneID'],
                $result['AirplaneTypeName'],
                $result['_Condition'],
                $result['StartingAirportID'],
                $result['StartingAirportName']
            );
        }

        return $this -> flights;
    }
}