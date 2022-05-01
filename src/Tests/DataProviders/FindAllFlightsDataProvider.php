<?php

namespace Tests\DataProviders;

use App\Entities\Flight;

class FindAllFlightsDataProvider
{
    public function FlightRequestRowsWhenEverythingIsOK(): array{
        $rows = [
            [
                1,
                "X",
                "Y",
                '2022-06-06 00:00:00',
                '2022-06-06 08:00:00',
                1,
                'Boeing 737 MAX',
                100,
                false
            ],
            [
                4,
                "Y",
                "Z",
                '2022-06-06 07:00:00',
                '2022-06-06 12:00:00',
                2,
                'Boeing 737 MAX',
                200,
                false
            ],
            [
                3,
                "X",
                "Z",
                '2022-06-07 07:00:00',
                '2022-06-07 16:00:00',
                2,
                'Boeing 737 MAX',
                200,
                false
            ],
            [
                2,
                "X",
                "Z",
                '2022-06-07 07:00:00',
                '2022-06-07 16:00:00',
                2,
                'Boeing 737 MAX',
                200,
                true
            ]
        ];
        $flights = [
            Flight::createForAllFlights(
                1,
                "X",
                "Y",
                '2022-06-06 00:00:00',
                '2022-06-06 08:00:00',
                1,
                'Boeing 737 MAX',
                100,
                null
            ),
            Flight::createForAllFlights(
                4,
                "Y",
                "Z",
                '2022-06-06 07:00:00',
                '2022-06-06 12:00:00',
                2,
                'Boeing 737 MAX',
                200,
                null
            ),
            Flight::createForAllFlights(
                3,
                "X",
                "Z",
                '2022-06-07 07:00:00',
                '2022-06-07 16:00:00',
                2,
                'Boeing 737 MAX',
                200,
                null
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
        $rows = [ // Dates collision
            [
                1,
                "X",
                "Y",
                '2022-06-06 00:00:00',
                '2022-06-06 08:00:00',
                1,
                'Boeing 737 MAX',
                100,
                false
            ],
            [
                2,
                "Y",
                "Z",
                '2022-06-06 07:00:00',
                '2022-06-06 12:00:00',
                1,
                'Boeing 737 MAX',
                100,
                false
            ]
        ];

        $data[] = [
            $rows,
            "This flight can\'t take place because another flight is scheduled at the time"
        ];

        $rows = [   // starting airport collision
            [
                1,
                "X",
                "Y",
                '2022-06-06 00:00:00',
                '2022-06-06 08:00:00',
                1,
                'Boeing 737 MAX',
                100,
                false
            ],
            [
                2,
                "Z",
                "X",
                '2022-06-06 10:00:00',
                '2022-06-06 18:00:00',
                1,
                'Boeing 737 MAX',
                100,
                false
            ]
        ];

        $data[] = [
            $rows,
            "This flight can\'t take place because of improper starting airport"
        ];
        return $data;
    }
}