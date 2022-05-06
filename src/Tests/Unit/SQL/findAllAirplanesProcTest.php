<?php

namespace Tests\Unit\SQL;

use App\DataBaseConnection;

class findAllAirplanesProcTest extends SQLTestBaseClass
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    private $keys = [
        'FlightID',
        'DateTimeOfDeparture',
        'StartingAirportName',
        'TargetAirportName',
        'AirplaneID',
        'AirplaneTypeName',
    ];

    /** @test */
    public function example_correct_output(){
        // given
        $expected = [
            [1,'2022-06-06 08:00:00','X','Y',1,'Boeing 737 MAX'],
            [2,'2022-06-06 14:00:00','Y','Z',1,'Boeing 737 MAX'],
            [3,'2022-06-06 08:00:00','X','Y',2,'Boeing 737 MAX'],
            [4,'2022-06-06 14:00:00','Y','Z',2,'Boeing 737 MAX'],
            [5,'2022-06-06 20:00:00','Z','X',2,'Boeing 737 MAX'],
        ];

        // when
        $statement = $this -> connection -> getPDO() -> prepare('CALL findAllFlightsSetUp()');
        $statement -> execute();

        $statement = $this -> connection -> getPDO() -> prepare('CALL findAllFlights()');
        $statement -> execute();

//        print_r(array_map(
//            fn($x) => array_combine($this -> keys,$x ),
//            $expected
//        ));
//        print_r($statement -> fetchAll());
//
        print_r(array_map(
            fn($x) => array_combine($this -> keys,$x ),
            $expected
        ) == $expected);
        // then
        $this -> assertEquals(
            array_map(
                fn($x) => array_combine($this -> keys,$x ),
                $expected
            ),
            $statement -> fetchAll()
        );

    }
}