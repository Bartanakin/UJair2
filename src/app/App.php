<?php

declare(strict_types=1);
namespace App;

class App
{
    private $router;
    private static $dbConnection;

    function __construct(protected string $method, protected string $uri,array $dbCredentials){
        $this -> router = new Router();
        static::$dbConnection = new DataBaseConnection($dbCredentials);
    }

    function getRouter(): Router {
        return $this -> router;
    }

    function run(){
        echo $this -> router -> resolve($this -> method,$this -> uri);
    }

    public static function getDataBaseConnection(): DataBaseConnection {
        return static::$dbConnection;
    }


}