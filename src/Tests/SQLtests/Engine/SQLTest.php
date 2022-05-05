<?php

namespace Tests\SQLtests\Engine;

use App\DataBaseConnection;

abstract class SQLTest
{
    private array $tests = [];
    private static int $assertions = 0;
    private static int $failures = 0;
    public function __construct(
        protected DataBaseConnection $connection
    )
    {
    }

    public static function runAllTests(array $allClasses,DataBaseConnection $connection)
    {
        foreach ($allClasses as $class){
            $object = new $class($connection);
            call_user_func([$object,'runTest']);
        }
        echo 'Assertions: ' . static::$assertions . ' Failures: '. static::$failures. PHP_EOL;
    }

    private function registerTests(){
        $reflection = new \ReflectionClass(static::class);
        foreach ( $reflection -> getMethods() as $method ){
            //print_r(array_map(fn($x) => $x->getName(),$method->getAttributes()));
            //print_r(TestAttribute::class);
            if(in_array(
                TestAttribute::class,
                array_map(fn($x) => $x->getName(),$method->getAttributes())
            )){
                $this -> tests[] = $method -> getName();
            }
        }
    }

    public function runTest(){
        $this -> registerTests();
        foreach ( $this -> tests as $test ){
            $this -> setUp();
            call_user_func([$this,$test]);
        }
    }


    public function setUp(){

    }

    public function assertEquals($expected,$given){
        if( $expected == $given ){
            static::$assertions++;
        }
        else{
            static::$failures++;
            echo "Failure in " . static::class . " class.". PHP_EOL;
        }
    }
}