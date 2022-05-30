<?php

namespace App\Models\EditCrewModels;


use App\DataBaseConnection;
use App\Entities\PersonClasses\Employee;
use App\Entities\PersonClasses\EmployeeDegree;
use App\Model;

class CrewEditorImpl extends Model implements \App\Interfaces\EditCrewInterfaces\CrewEditor
{
    public function __construct(DataBaseConnection $db)
    {
        parent::__construct($db);
    }

    public function linkMember(Employee $employee, EmployeeDegree $role, int $flightID): bool
    {
        $statement = $this -> getDBConnection() -> prepare(
            'INSERT INTO CrewList(FlightID,EmployeeID,RoleID) VALUES (?,?,?)'
        );
        $statement -> execute([$flightID, $employee -> getID(),$role -> value]);
        return true;
    }

    public function unLinkMember(Employee $employee, int $flightID): bool
    {
        $statement = $this -> getDBConnection() -> prepare(
            'DELETE FROM CrewList WHERE FlightID = ? AND EmployeeID = ?'
        );
        $statement -> execute([$flightID, $employee -> getID()]);
        return true;
    }
}