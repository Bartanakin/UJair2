<?php

namespace App\Models\EditCrewModels;

use App\DataBaseConnection;
use App\Entities\CrewList;
use App\Entities\PersonClasses\FlightAttendant;
use App\Entities\PersonClasses\Pilot;
use App\Model;

class FindCrewForFlightImpl extends Model implements \App\Interfaces\FindCrewForFlight
{
    public function __construct(DataBaseConnection $dataBaseConnection)
    {
        parent::__construct($dataBaseConnection);
    }

    private function findMaxNumberOfFA(int $flightID): int {
        $statement = $this -> getDBConnection() -> prepare('CALL findMaxNumberOfFA(?);');

        $statement -> execute([$flightID]);
        $result = $statement -> fetch()['maxNumberOfFA'];
        if( ! is_integer($result) )
            throw new \PDOException('Max number of FA is not an integer!');
        return $result;
    }

    public function findCrewForFlight(int $flightID): CrewList {
        $statement = $this -> getDBConnection() -> prepare('CALL findCrewListOfFlight(?)');
        $statement -> execute([$flightID]);

        $FA = [];
        $FO = null;
        $Cap = null;
        while ($row = $statement -> fetch() ){
            switch($row['RoleID']){
                case 'C':
                    $Cap = Pilot::createForFindCrew(
                        $row['EmployeeID'],
                        $row['FirstName'],
                        $row['Surname'],
                        $row['Degree']
                    );
                    break;
                case 'F':
                    $FO = Pilot::createForFindCrew(
                        $row['EmployeeID'],
                        $row['FirstName'],
                        $row['Surname'],
                        $row['Degree']
                    );
                    break;
                case 'S':
                    $FA[] = FlightAttendant::createForFindCrew(
                        $row['EmployeeID'],
                        $row['FirstName'],
                        $row['Surname']
                    );
                    break;
                default:
                    throw new \PDOException("Employee degree error");
            }
        }

        return CrewList::createForFindCrew(
            $this -> findMaxNumberOfFA($flightID),
            $FA,
            $Cap,
            $FO
        );
    }
}