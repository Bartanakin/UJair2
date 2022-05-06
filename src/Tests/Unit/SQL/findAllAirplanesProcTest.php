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
        $expected = [
            [1,'2022-06-06 08:00:00',],
            [2,'2022-06-06 14:00:00',],
            [3,'2022-06-06 08:00:00',],
            [4,'2022-06-06 14:00:00',],
            [5,'2022-06-06 20:00:00',],

        ];
    }
}