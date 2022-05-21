<?php

namespace Tests\Unit\SQL;

class FindTargetAirportsTest extends SQLTestBaseClass
{
    protected function setUp(): void
    {
        parent::setUp();
        $s = $this -> connection -> getPDO() -> prepare("CALL findTargetAirportsSetUp();");
        $s -> execute();
    }

    protected array $keys = [
        'TargetAirportID',
        'TargetAirportName'
    ];

    protected function examples(){
        return [
            [
                'X',
                1500,
                [
                    [
                        2,
                        'Y'
                    ]
                ]
            ],
            [
                'Y',
                1500,
                [
                    [
                        3,
                        'Z'
                    ]
                ]
            ]
        ];
    }

    /** @test
     *  @dataProvider  examples
     */
    public  function checks_query($name,$maxDistance,$expected){
        $s = $this -> connection -> getPDO() -> prepare('CALL FindAllTargetAirports(?,?);');
        $s -> execute([$name,$maxDistance]);

        $this -> assertEquals(
            array_map(
                fn($x) => array_combine($this -> keys,$x ),
                $expected
            ),
            $s -> fetchAll()
        );
    }

}