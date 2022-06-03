<?php

namespace Tests\DataProviders;

use App\Entities\CrewList;
use App\Entities\PersonClasses\FlightAttendant;
use App\Entities\PersonClasses\Pilot;

class FindCrewForFlightProvider
{
    public function exampleQueryResult(){
        $maxNumberOfFA = 100;
        $rows = [
            [
                'F',
                1,
                'Jan',
                'Kowalski',
                'F'
            ],
            [
                'S',
                2,
                'Eliza',
                'Kochanowska',
                'S'
            ]
        ];
        $returned = CrewList::createForFindCrew(
            $maxNumberOfFA,
            [ FlightAttendant::createForFindCrew(2,'Eliza','Kochanowska')],
            null,
            Pilot::createForFindCrew(1,'Jan','Kowalski','F')
        );

        return [
          [
              $returned,
              $rows,
              $maxNumberOfFA
          ]
        ];
    }
}