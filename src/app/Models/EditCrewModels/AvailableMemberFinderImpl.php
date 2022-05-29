<?php

namespace App\Models\EditCrewModels;

use App\DataBaseConnection;
use App\Entities\PersonClasses\EmployeeDegree;
use App\Entities\PersonClasses\FlightAttendant;
use App\Entities\PersonClasses\Pilot;
use App\Interfaces\EditCrewInterfaces\AvailableMemberFinder;
use App\Model;

class AvailableMemberFinderImpl extends Model implements AvailableMemberFinder
{

    public function __construct(DataBaseConnection $db)
    {
        parent::__construct($db);
    }

    public function run(EmployeeDegree $degree): array
    {
        $statement = $this -> getDBConnection() -> prepare('CALL FindSuitableEmployees(?);');

        $statement -> execute([$degree -> value ]);
        $candidates = [];
        while( $row = $statement -> fetch() ){
            if( $row['empDegree'] === 'S')
                $employee = FlightAttendant::createForFindCrew(
                    $row['ID'],
                    $row['FirstName'],
                    $row['Surname'],
                );
            else
                $employee = Pilot::createForFindCrew(
                    $row['ID'],
                    $row['FirstName'],
                    $row['Surname'],
                    $row['empDegree']
                );
            $candidates[] = $employee;
        }
        return $candidates;
    }
}