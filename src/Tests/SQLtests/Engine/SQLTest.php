<?php

namespace Tests\SQLtests\Engine;

use App\DataBaseConnection;

class SQLTest
{

    public function __construct(
        protected ?DataBaseConnection $connection = null
    )
    {
       $this->connection = new DataBaseConnection(CONNECT);
    }

    public function setUp(){

    }

    public function assert(){

    }
}