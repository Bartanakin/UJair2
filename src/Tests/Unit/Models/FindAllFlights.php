<?php

namespace Tests\Unit\Models;

use App\Models\FindAllFlightsImpl;

class FindAllFlights extends ModelTestBaseClass
{
    private FindAllFlightsImpl $findAllFlightsImpl;
    private array $queryKeys = [
        'ID',
        'StartingAirportName',
        'TargetAirportName',
        'DateTimeOfDeparture',
        'EstimatedArrivalTime',
        'AirPlaneID',
        'AirplaneTypeName',
        'Price',
        'Canceled'
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this -> findAllFlightsImpl = new FindAllFlightsImpl($this -> dataBaseConnectionMock);

    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\FindAllFlightsDataProvider::FlightRequestRowsWhenFlightsCollide()
     */
    public function checks_warnings_with_fetch($values,$expected){
        $this -> pdoStatementMock -> method('fetch') -> willReturn(
            $this -> onConsecutiveCalls(
                array_combine($this -> queryKeys, $values[0]),
                array_combine($this -> queryKeys, $values[1]),
                null
            )
        );
        $result = $this -> findAllFlightsImpl -> findAllFlights();
        if(2 ==  sizeof($result)){
            $this -> fail("The array size is to small given ".sizeof($result)." expected 2.");
        }
        else{
            $this -> assertEquals($expected,$result[1] -> get('warning'));
        }
    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\FindAllFlightsDataProvider::FlightRequestRowsWhenEverythingIsOK()
     */
    public function checks_example_result_with_fetch($values,$expected){
        $this -> pdoStatementMock -> method('fetch') -> willReturn(
            $this -> onConsecutiveCalls(
                array_combine($this -> queryKeys, $values[0]),
                array_combine($this -> queryKeys, $values[1]),
                array_combine($this -> queryKeys, $values[2]),
                array_combine($this -> queryKeys, $values[3]),
                null
            )
        );
        $result = $this -> findAllFlightsImpl -> findAllFlights();
        $this -> assertEquals($expected,$result);
    }
}