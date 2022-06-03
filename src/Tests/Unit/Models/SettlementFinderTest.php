<?php

namespace Tests\Unit\Models;

use App\Entities\SettlementClasses\SalaryExpense;
use App\Interfaces\Currents;
use App\Interfaces\SettlementInterfaces\SettlementFinder;
use App\Models\SettlementModels\SettlementFinderImpl;
use DateTime;
use PHPUnit\Framework\MockObject\MockObject;

class SettlementFinderTest extends ModelTestBaseClass
{
    protected MockObject $current;
    protected SettlementFinder $finder;
    protected array $keys = ['DateOfEmployment','Salary'];
    protected function setUp(): void
    {
        parent::setUp();
        $this -> current = $this->createMock(Currents::class);

        $this -> finder = new SettlementFinderImpl(
            $this -> dataBaseConnectionMock,
            $this -> current
        );
    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\SettlementsFinderDP::find_salariesDP
     * @preserveGlobalState disabled
     */
    public function checks_find_salaries($now,$expected,$values){
        $this -> current -> method('now') -> willReturn($now);
        $this -> pdoStatementMock
            -> method('fetch')
            ->willReturn($this -> onConsecutiveCalls(
                array_combine($this -> keys, $values[0]),
                array_combine($this -> keys, $values[1]),
                null
            ));
        $result = $this -> finder -> findSalaries();

        $this -> assertEquals($expected,$result);
    }
}