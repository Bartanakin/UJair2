<?php

namespace Tests\Unit\Models;

use App\Interfaces\FlightWarningAdder;
use App\Models\FindAllFlightsImpl;
use App\Models\FlightWarningAdderImpl;
use PHPUnit\Framework\MockObject\MockObject;

class FindAllFlights extends ModelTestBaseClass
{
    private FindAllFlightsImpl $findAllFlightsImpl;

    private FlightWarningAdder $flightWarningAdder;
    private array $queryKeys = [
        'FlightID',
        'StartingAirportName',
        'TargetAirportName',
        'DateTimeOfDeparture',
        'AirplaneID',
        'AirplaneTypeName',
        'Price'
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this -> flightWarningAdder = new FlightWarningAdderImpl();

        $this -> findAllFlightsImpl = new FindAllFlightsImpl(
            $this -> dataBaseConnectionMock,
            $this -> flightWarningAdder
        );

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
        if(2 !=  sizeof($result)){
            $this -> fail("The array size is to small given ".sizeof($result)." expected 2.");
        }
        else{
            $this -> assertEquals($expected,$result[1] -> warning);
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
                null
            )
        );
        $result = $this -> findAllFlightsImpl -> findAllFlights();
//        print_r($expected);
//        print_r($result);
        $this -> assertEquals($expected,$result);
    }
}