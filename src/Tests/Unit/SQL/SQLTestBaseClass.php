<?php

namespace Tests\Unit\SQL;

use App\DataBaseConnection;

class SQLTestBaseClass extends \PHPUnit\Framework\TestCase
{
    protected DataBaseConnection $connection;

    protected function setUp(): void
    {
        parent::setUp();
        $this -> connection = new DataBaseConnection(CONNECT);
    }
}