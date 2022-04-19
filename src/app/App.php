<?php

declare(strict_types=1);
namespace App;

class App
{
    protected Router $router;
    private static DataBaseConnection $dbConnection;
    protected Container $container;

    function __construct(protected string $method, protected string $uri,array $dbCredentials){
        $this -> container = new Container();
        $this -> router = new Router( $this -> container );
        static::$dbConnection = new DataBaseConnection($dbCredentials);

        /*
         * $this -> container -> set(
         *      <interface name>::class,
         *      <class name>::class
         * );
         */
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