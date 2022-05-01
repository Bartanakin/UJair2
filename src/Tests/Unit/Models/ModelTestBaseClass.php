<?php

namespace Tests\Unit\Models;

use App\DataBaseConnection;
use App\Models\FindAllFlightsImpl;
use PDO;
use PHPUnit\Framework\TestCase;

class ModelTestBaseClass extends TestCase
{
    protected DataBaseConnection $dataBaseConnectionMock;
    protected PDO $pdoMock;
    protected \PDOStatement $pdoStatementMock;
    protected function setUp(): void
    {
        parent::setUp();
        $this -> dataBaseConnectionMock = $this -> createMock(DataBaseConnection::class);
        $this -> pdoMock = $this -> createMock(PDO::class);
        $this -> pdoStatementMock = $this -> createMock(\PDOStatement::class);
        $this -> dataBaseConnectionMock -> method('getPDO') -> willReturn($this ->pdoMock);
        $this -> pdoMock -> method('prepare') -> willReturn($this -> pdoStatementMock);

    }
}