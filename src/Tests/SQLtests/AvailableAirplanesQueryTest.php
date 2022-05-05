<?php

namespace Tests\SQLtests;

use App\DataBaseConnection;

class AvailableAirplanesQueryTest extends Engine\SQLTest
{

    public function __construct(?DataBaseConnection $connection = null)
    {
        parent::__construct($connection);
    }

    public function setUp(){
        $stmt = $this -> connection -> getPDO() -> prepare('CALL FindAllAirplanesTestPrepare();');
        $stmt -> execute();
    }

    public function test(){
        $expected = [
            [ 'id' => 1, 'value1' => 10 ],
            [ 'id' => 2, 'value1' => 10 ]
        ];
        $stmt = $this -> connection -> getPDO() -> prepare('CALL TestQueryProcedure();');
        $stmt -> execute();

        $result = $stmt -> fetchAll();
        if( $expected === $result ){
            print "Congrats test has passed!";
        }
        else{
            print_r($expected);
            print_r($result) ;
            print "Warning! Test has failed!";
        }
    }
}