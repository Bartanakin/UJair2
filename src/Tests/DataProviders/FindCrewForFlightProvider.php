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
                1,
                'Jan Kowalski',
                'F'
            ],
            [
                1,
                'Eliza Kochanowska',
                'S'
            ]
        ];
        $returned = CrewList::createForFindCrew(
            $maxNumberOfFA,
            [ FlightAttendant::createForFindCrew(1,'Eliza Kochanowska')],
            null,
            Pilot::createForFindCrew(1,'Jan Kowalski')
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