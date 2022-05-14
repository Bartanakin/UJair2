<?php

namespace Tests\Unit\SQL;

use App\Entities\AirplanePosition;

class FindAvailableAirplanesTest extends SQLTestBaseClass
{
    protected $keys = [
        'AirplaneID',
        'AirplaneTypeName',
        '_Condition',
        'StartingAirportID',
        'StartingAirportName'
    ];
    protected function setUp(): void
    {
        parent::setUp();

        $s = $this -> connection -> getPDO() -> prepare("CALL findAvailableAirplanesSetUp();");
        $s -> execute();

    }

    public function check_proc_data_provider(){
        return [
            [ // test 1
                '2022-06-06 21:00:00',
                [ // all rows
                    [
                        1,
                        'Boeing 737 MAX',
                        AirplanePosition::FREE->value,
                        3,
                        'Z'
                    ],
                    [
                        2,
                        'Boeing 737 MAX',
                        AirplanePosition::IN_FLIGHT->value,
                        1,
                        'X'
                    ],
                ],

            ], // test 2
            [ // all rows
                '2022-06-06 07:40:00',
                [
                    [
                        1,
                        'Boeing 737 MAX',
                        AirplanePosition::AFTER_FLIGHT->value,
                        2,
                        'Y'
                    ],
                    [
                        2,
                        'Boeing 737 MAX',
                        AirplanePosition::PREPARING_FOR_FLIGHT->value,
                        1,
                        'X'
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider check_proc_data_provider
     */
    public function check_proc($date,$rows){
        $stmt = $this -> connection -> getPDO() -> prepare('CALL FindAllAirplanes(?);');
        $stmt -> execute([$date]);

        $this -> assertEquals(array_map(
            fn($x) => array_combine($this -> keys,$x ),
            $rows
        ), $stmt -> fetchAll());
    }
}