<?php

namespace Tests\Unit\SQL;

use App\DataBaseConnection;

require_once __DIR__ . '/../../../connect.php';

class SQLTestBaseClass extends \PHPUnit\Framework\TestCase
{
    protected DataBaseConnection $connection;

    protected function setUp(): void
    {
        parent::setUp();
        $this -> connection = new DataBaseConnection(CONNECT);
    }
}