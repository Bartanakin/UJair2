<?php

namespace Tests\Unit\SQL;

class FindCrewForFlightTest extends SQLTestBaseClass
{
    protected function setUp(): void
    {
        parent::setUp();
        $s = $this -> connection -> getPDO() -> prepare("CALL findCrewForFlightSetUp();");
        $s -> execute();
    }

    /** @test */
    public function checks_max_number_of_FA(){
        $s = $this -> connection -> getPDO() -> prepare('CALL findMaxNumberOfFA(?);');
        $s -> execute([1]);

        $this -> assertEquals(
            [ ['maxNumberOfFA' => 3] ],
            $s -> fetchAll()
        );
    }


    protected $keys = [
        'RoleID',
        'EmployeeID',
        'FirstName',
        'Surname',
        'Degree'
    ];

    public function example1(){
        return [
              [ // Flight 1
                  1,
                  [
                      ['F', 1, 'Albert', 'Kowalski', 'C'],
                      ['C', 3, 'Joanna', 'Kowalczyk', 'C'],
                      ['S',5,'Joanna','Kołaczkowska','S'],
                      ['S',6,'Aniela','Chmielewska','S'],
                  ],
              ], // Flight 2
                [
                    2,
                    [
                        ['F', 2, 'Jan', 'Płatwiński', 'F'],
                        ['C', 3, 'Joanna', 'Kowalczyk', 'C']
                    ],
                ], // Flight 3
                [
                    3,
                    [
                        ['F', 2, 'Jan', 'Płatwiński', 'F'],
                        ['C', 3, 'Joanna', 'Kowalczyk', 'C'],
                        ['S',5,'Joanna','Kołaczkowska','S'],
                        ['S',6,'Aniela','Chmielewska','S'],
                        ['S',7,'Żaneta','Szewczyk','S']
                    ],
                ]
            ];
    }

    /**
     * @test
     * @dataProvider example1
     */
    public function checks_example_output($flightID,$expected){
        $s = $this -> connection -> getPDO() -> prepare('CALL findCrewListOfFlight(?);');
        $s -> execute([$flightID]);

        $this -> assertEquals(
            array_map(
                fn($x) => array_combine($this -> keys,$x),
                $expected
            ),
            $s -> fetchAll()
        );
    }
}