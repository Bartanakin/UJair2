<?php

namespace Tests\Unit\Models;

use App\Exceptions\IncorrectLoginException;
use App\Exceptions\IncorrectPasswordException;
use App\Models\PlannerLoginImpl;

class PlannerLoginImplTest extends ModelTestBaseClass
{

    private PlannerLoginImpl $plannerLoginImpl;
    protected function setUp(): void
    {
        parent::setUp();

        $this -> plannerLoginImpl = new PlannerLoginImpl(
              $this -> dataBaseConnectionMock
        );
    }

    /** @test */
    public function check_successful_password_check(){
        $this -> pdoStatementMock -> method('rowCount') -> willReturn(1);
        $this -> pdoStatementMock -> method('fetch') -> willReturn(
            ['PasswordHash' => '$2y$10$OpVUi.itegJOT5pOxYD66ejZtUBJD4wdogw6kOE1wq4e1O0xmfXhG']
        );

        $this -> assertTrue($this -> plannerLoginImpl -> login('planner1','haslo_planisty'));
    }

    /** @test */
    public function check_incorrect_username(){
        $this -> pdoStatementMock -> method('rowCount') -> willReturn(0);

        $this -> expectException(IncorrectLoginException::class);

        $this -> plannerLoginImpl -> login('planner1','haslo_planisty');
    }

    /** @test */
    public function check_incorrect_password(){
        $this -> pdoStatementMock -> method('rowCount') -> willReturn(1);
        $this -> pdoStatementMock -> method('fetch') -> willReturn(
            ['PasswordHash' => '$2y$10$OpVUi.itegJOT5pOxYD66ejZtUBJD4wdogw6kOE1wq4e1O0xmfXhG']
        );
        $this -> expectException(IncorrectPasswordException::class);

        $this -> plannerLoginImpl -> login('planner1','inne_haslo');
    }
}