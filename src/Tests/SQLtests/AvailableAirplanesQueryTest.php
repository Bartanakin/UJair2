<?php

namespace Tests\SQLtests;

use App\DataBaseConnection;
use Tests\SQLtests\Engine\TestAttribute;

class AvailableAirplanesQueryTest extends Engine\SQLTest
{

    public function __construct(DataBaseConnection $connection)
    {
        parent::__construct($connection);
    }

    public function setUp(){
        $stmt = $this -> connection -> getPDO() -> prepare('CALL FindAllAirplanesTestPrepare();');
        $stmt -> execute();
    }

    #[TestAttribute]
    public function test_test(){
        $expected = [
            [ 'id' => 1, 'value1' => 10 ],
            [ 'id' => 2, 'value1' => 10 ]
        ];
        $stmt = $this -> connection -> getPDO() -> prepare('CALL TestQueryProcedure();');
        $stmt -> execute();

        $result = $stmt -> fetchAll();
        $this -> assertEquals($expected,$result);
    }
}