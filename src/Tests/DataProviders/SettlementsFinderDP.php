<?php

namespace Tests\DataProviders;

use App\Entities\SettlementClasses\SalaryExpense;

class SettlementsFinderDP
{
    public function find_salariesDP(): array {

        return [
            [
                \DateTime::createFromFormat("Y-m-d H:i:s",'2022-06-06 00:00:00'),
                [   // expected
                    SalaryExpense::createForAllSalaryMonths(\DateTime::createFromFormat("Y-m-d H:i:s",'2022-05-03 00:00:00'),10000),
                    SalaryExpense::createForAllSalaryMonths(\DateTime::createFromFormat("Y-m-d H:i:s",'2022-06-03 00:00:00'),10000)
                ],
                [   // fetch result
                    [
                        '2022-04-03 00:00:00',
                        10000
                    ],
                    [
                        '2022-05-07 00:00:00',
                        20000
                    ]
                ]
            ]
        ];
    }
}