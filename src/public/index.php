<?php

use App\App;
use App\Controllers\PassengerAppControllers\BookingTicketsController;
use App\Controllers\PassengerAppControllers\PassengerLoginController;
use App\Controllers\PassengerAppControllers\PassengerRegistrationController;
use App\Controllers\PassengerAppControllers\PassengersTicketsController;
use App\Controllers\PlannerAppControllers\HomeController;

require __DIR__ . '/../vendor/autoload.php';

const VIEW_PATH = __DIR__ . '/../views';
require_once __DIR__ . '/../connect.php';

session_start();

$app = new App($_SERVER["REQUEST_METHOD"],$_SERVER["REQUEST_URI"],CONNECT);

$app -> getRouter() -> get('/',[HomeController::class, 'index']);
$app -> getRouter() -> post("/",[\App\Controllers\PlannerAppControllers\PlannerLoginController::class,'login']);
$app -> getRouter() -> get("/editFlight",[\App\Controllers\PlannerAppControllers\AllFlightsController::class,'addFlight']);
$app -> getRouter() -> post("/editFlight",[\App\Controllers\PlannerAppControllers\AllFlightsController::class,'editFlight']);
$app -> getRouter() -> post("/editCrew",[\App\Controllers\PlannerAppControllers\AllFlightsController::class,'editCrew']);


$app -> getRouter() -> get("/style",[\App\Controllers\StyleController::class,'loginPage']);
$app -> getRouter() -> get("/commonStyle",[\App\Controllers\StyleController::class,'common']);
$app -> getRouter() -> get("/allFlightsStyles",[\App\Controllers\StyleController::class,'allFlights']);

//==========
$app -> getRouter() -> get("/getAvailableSeats",[BookingTicketsController::class, "getAvailableSeats"]);
$app -> getRouter() -> get("/getAllAirports",[BookingTicketsController::class, "getAllAirports"]);
$app -> getRouter() -> get("/getScheduleForRoute",[BookingTicketsController::class, "getScheduleForRoute"]);
$app -> getRouter() -> get("/getTargetAirports",[BookingTicketsController::class, "getTargetAirports"]);
$app -> getRouter() -> get("/insertTicket",[BookingTicketsController::class,'insertTicket']);
$app -> getRouter() -> get("/getPassengerIDIfExists",[PassengerLoginController::class,'getPassengerIDIfExists']);
$app -> getRouter() -> get("/canAddLogin",[PassengerRegistrationController::class,'canAddLogin']);
$app -> getRouter() -> get("/loadCountries",[PassengerRegistrationController::class,'loadCountries']);
$app -> getRouter() -> get("/insertPassenger",[PassengerRegistrationController::class,'insertPassenger']);
$app -> getRouter() -> get("/getTicketsForPassengerID",[PassengersTicketsController::class,'getTicketsForPassengerID']);


$app -> run();