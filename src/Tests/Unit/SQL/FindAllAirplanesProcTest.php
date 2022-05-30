<?php

namespace Tests\Unit\SQL;

use App\DataBaseConnection;

class
FindAllAirplanesProcTest extends SQLTestBaseClass
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    private array $keys = [
        'FlightID',
        'DateTimeOfDeparture',
        'StartingAirportName',
        'TargetAirportName',
        'AirplaneID',
        'AirplaneTypeName',
        'Price'
    ];

    /** @test */
    public function example_correct_output(){
        // given
        $expected = [
            [1,'2022-06-06 08:00:00','X','Y',1,'Boeing 737 MAX',100],
            [2,'2022-06-06 14:00:00','Y','Z',1,'Boeing 737 MAX',100],
            [3,'2022-06-06 08:00:00','X','Y',2,'Boeing 737 MAX',100],
            [4,'2022-06-06 14:00:00','Y','Z',2,'Boeing 737 MAX',100],
            [5,'2022-06-06 20:00:00','Z','X',2,'Boeing 737 MAX',100],
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