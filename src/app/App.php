<?php

declare(strict_types=1);
namespace App;

use App\Exceptions\UnauthorizedPageAccessException;
use App\Interfaces\BookingTicketsInterfaces\AllAirportsGetter;
use App\Interfaces\BookingTicketsInterfaces\InsertionNewTicket;
use App\Interfaces\BookingTicketsInterfaces\ScheduleOfRouteGetter;
use App\Interfaces\BookingTicketsInterfaces\SeatsGetter;
use App\Interfaces\BookingTicketsInterfaces\TargetAirportsGetter;
use App\Interfaces\FindAllFlights;
use App\Interfaces\PassengerLoginInterfaces\LoginAndPasswordVerification;
use App\Interfaces\PassengerRegistrationInterfaces\LoginChecker;
use App\Interfaces\PlannerLoginInterface;
use App\Models\BookingTicketsModels\AllAirportsGetterImpl;
use App\Models\BookingTicketsModels\InsertionNewTicketImpl;
use App\Models\BookingTicketsModels\ScheduleOfRouteGetterImpl;
use App\Models\BookingTicketsModels\SeatsGetterImpl;
use App\Models\BookingTicketsModels\TargetAirportsGetterImpl;
use App\Models\FindAllFlightsImpl;
use App\Models\PassengerLoginModels\LoginAndPasswordVerificationImpl;
use App\Models\PassengerRegistrationModels\LoginCheckerImpl;
use App\Models\PlannerLoginImpl;

class App
{
    protected Router $router;
    private static DataBaseConnection $dbConnection;
    protected Container $container;

    function __construct(protected string $method, protected string $uri,array $dbCredentials){
        $this -> container = new Container();
        $this -> router = new Router( $this -> container );
        static::$dbConnection = new DataBaseConnection($dbCredentials);

        // Container bindings:
        $this -> container -> set(AllAirportsGetter::class, AllAirportsGetterImpl::class);
        $this -> container -> set(ScheduleOfRouteGetter::class, ScheduleOfRouteGetterImpl::class);
        $this -> container -> set(TargetAirportsGetter::class, TargetAirportsGetterImpl::class);
        $this -> container -> set(PlannerLoginInterface::class, PlannerLoginImpl::class);
        $this -> container -> set(FindAllFlights::class, FindAllFlightsImpl::class);
        $this -> container -> set(SeatsGetter::class, SeatsGetterImpl::class);
        $this -> container -> set(InsertionNewTicket::class, InsertionNewTicketImpl::class);
        $this -> container -> set(LoginAndPasswordVerification::class, LoginAndPasswordVerificationImpl::class);
        $this -> container -> set(LoginChecker::class, LoginCheckerImpl::class);

        $this -> container -> set(DataBaseConnection::class,function(Container $c){
            return App::getDataBaseConnection();
        });
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

    public function assertLogged(){
        if( isset($_SESSION['logged']) ){
            if( $_SESSION['logged'] === true ){
                return;
            }
        }
        throw new UnauthorizedPageAccessException();
    }

}