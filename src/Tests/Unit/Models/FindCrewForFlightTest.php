<?php

namespace Tests\Unit\Models;

use App\Interfaces\FindCrewForFlight;
use App\Models\EditCrewModels\FindCrewForFlightImpl;

class FindCrewForFlightTest extends ModelTestBaseClass
{
    private FindCrewForFlight $findCrewForFlight;
    private $keys = [
        'RoleID',
        'EmployeeID',
        'FirstName',
        'Surname',
        'Degree'
    ];
    protected function setUp(): void
    {
        parent::setUp();
        $this -> findCrewForFlight = new FindCrewForFlightImpl($this -> dataBaseConnectionMock);

    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\FindCrewForFlightProvider::exampleQueryResult()
     */
    public function checks_if_correct_crew_list_object_is_returned($expected,$rows,$maxNumberOfFA){
        $this -> pdoStatementMock
            -> method('fetch')
            -> willReturn( $this -> onConsecutiveCalls(
                ['maxNumberOfFA' => $maxNumberOfFA],
                array_combine($this -> keys,$rows[0]),
                array_combine($this -> keys,$rows[1])
            ));

        $this -> assertEquals($expected,$this -> findCrewForFlight -> findCrewForFlight(1));
    }
}