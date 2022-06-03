<?php

namespace Tests\DataProviders;

use App\Entities\SettlementClasses\SalaryExpense;

class SettlementsFinderDP
{
    public function find_salariesDP(): array {

        return [
            [
                \DateTime::createFromFormat("Y-m-d",'2022-06-06'),
                [   // expected
                    SalaryExpense::createForAllSalaryMonths(\DateTime::createFromFormat("Y-m-d",'2022-05-03'),-10000),
                    SalaryExpense::createForAllSalaryMonths(\DateTime::createFromFormat("Y-m-d",'2022-06-03'),-10000)
                ],
                [   // fetch result
                    [
                        '2022-04-03',
                        10000
                    ],
                    [
                        '2022-05-07',
                        20000
                    ]
                ]
            ]
        ];
    }
}