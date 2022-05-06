<?php

namespace Tests\DataProviders;

use App\Entities\Flight;
use App\Models\FlightWarnings;

class FindAllFlightsDataProvider
{
    public function FlightRequestRowsWhenEverythingIsOK(): array{
        $rows = [
            [
                1,
                "X",
                "Y",
                '2022-06-06 00:00:00',
                1,
                'Boeing 737 MAX',
                100
            ],
            [
                4,
                "Y",
                "Z",
                '2022-06-06 07:00:00',
                1,
                'Boeing 737 MAX',
                200
            ],
            [
                3,
                "X",
                "Z",
                '2022-06-07 07:00:00',
                2,
                'Boeing 737 MAX',
                200
            ]
        ];
        $flights = [
            Flight::createForAllFlights(
                1,
                "X",
                "Y",
                '2022-06-06 00:00:00',
                1,
                'Boeing 737 MAX',
                100,
                ""
            ),
            Flight::createForAllFlights(
                3,
                "X",
                "Z",
                '2022-06-07 07:00:00',
                2,
                'Boeing 737 MAX',
                200,
                ""
            ),
            Flight::createForAllFlights(
                4,
                "Y",
                "Z",
                '2022-06-06 07:00:00',
                1,
                'Boeing 737 MAX',
                200,
                ""
            )
        ];
        return [
            [
                $rows,
                $flights
            ]
        ];
    }
    public function FlightRequestRowsWhenFlightsCollide(): array{
        $data = [];
//        $rows = [ // Dates collision
//            [
//                1,
//                "X",
//                "Y",
//                '2022-06-06 00:00:00',
//                1,
//                'Boeing 737 MAX',
//                100,
//                false
//            ],
//            [
//                2,
//                "Y",
//                "Z",
//                '2022-06-06 07:00:00',
//                1,
//                'Boeing 737 MAX',
//                100,
//                false
//            ]
//        ];
//
//        $data[] = [
//            $rows,
//            "This flight can\'t take place because another flight is scheduled at the time"
//        ];

        $rows = [   // starting airport collision
            [
                1,
                "X",
                "Y",
                '2022-06-06 00:00:00',
                1,
                'Boeing 737 MAX',
                100
            ],
            [
                2,
                "Z",
                "X",
                '2022-06-06 10:00:00',
                1,
                'Boeing 737 MAX',
                100
            ]
        ];

        $data[] = [
            $rows,
            FlightWarnings::AIRPORT_INCOHERENCE_WARNING->value
        ];
        return $data;
    }
}