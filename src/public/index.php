<?php

use App\App;
use App\Controllers\PassengerAppControllers\BookingTicketsController;
use App\Controllers\PassengerAppControllers\PassengerLoginController;
use App\Controllers\PlannerAppControllers\HomeController;

require __DIR__ . '/../vendor/autoload.php';

const VIEW_PATH = __DIR__ . '/../views';
require_once __DIR__ . '/../connect.php';

session_start();

$app = new App($_SERVER["REQUEST_METHOD"],$_SERVER["REQUEST_URI"],CONNECT);

$app -> getRouter() -> get('/',[HomeController::class, 'index']);
$app -> getRouter() -> post("/",[\App\Controllers\PlannerAppControllers\PlannerLoginController::class,'login']);
$app -> getRouter() -> get("/style",[\App\Controllers\LinksController::class,'style']);

//==========
$app -> getRouter() -> get("/getAvailableSeats",[BookingTicketsController::class, "getAvailableSeats"]);
$app -> getRouter() -> get("/getAllAirports",[BookingTicketsController::class, "getAllAirports"]);
$app -> getRouter() -> get("/getScheduleForRoute",[BookingTicketsController::class, "getScheduleForRoute"]);
$app -> getRouter() -> get("/getTargetAirports",[BookingTicketsController::class, "getTargetAirports"]);
$app -> getRouter() -> get("/insertTicket",[BookingTicketsController::class,'insertTicket']);
$app -> getRouter() -> get("/getPassengerIDIfExists",[PassengerLoginController::class,'getPassengerIDIfExists']);



$app -> run();


