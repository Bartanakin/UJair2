<?php

declare(strict_types=1);
namespace App;

use App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter;
use App\Interfaces\BookingTicketsInterfaces\ScheduleOfRouteGetter;
use App\Interfaces\BookingTicketsInterfaces\TargetAirportsGetter;
use App\Models\BookingTickets\AllAirportsGetterImpl;
use App\Models\BookingTickets\ScheduleOfRouteGetterImpl;
use App\Models\BookingTickets\TargetAirportsGetterImpl;

class App
{
    protected Router $router;
    private static DataBaseConnection $dbConnection;
    protected Container $container;

    function __construct(protected string $method, protected string $uri,array $dbCredentials){
        $this -> container = new Container();
        $this -> router = new Router( $this -> container );
        static::$dbConnection = new DataBaseConnection($dbCredentials);


        // To bind a specific class to an interface use this line:
        $this -> container -> set(AllAirportsGetter::class, AllAirportsGetterImpl::class);
        $this -> container -> set(ScheduleOfRouteGetter::class, ScheduleOfRouteGetterImpl::class);
        $this -> container -> set(TargetAirportsGetter::class, TargetAirportsGetterImpl::class);
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