<?php

use App\App;
use App\Controllers\PassengerAppControllers\BookingTicketsController;
use App\Controllers\PassengerAppControllers\PassengerLoginController;
use App\Controllers\PassengerAppControllers\PassengerRegistrationController;
use App\Controllers\PassengerAppControllers\PassengersTicketsController;
use App\Controllers\PlannerAppControllers\HomeController;

require __DIR__ . '/../vendor/autoload.php';

const VIEW_PATH = __DIR__ . '/../views';
const VENDOR_PATH = __DIR__ . '/../vendor';
require_once __DIR__ . '/../connect.php';

session_start();

$app = new App($_SERVER["REQUEST_METHOD"],$_SERVER["REQUEST_URI"],CONNECT);

// Planner app:
$app -> getRouter() -> get('/',[HomeController::class, 'index']);
$app -> getRouter() -> post("/",[\App\Controllers\PlannerAppControllers\AllFlightsController::class,'login']);
$app -> getRouter() -> get("/editFlight",[\App\Controllers\PlannerAppControllers\EditCrewController::class,'addFlight']);
$app -> getRouter() -> get("/settlements",[\App\Controllers\PlannerAppControllers\SettlementController::class,'settlementsPage']);
$app -> getRouter() -> post("/selectDate",[\App\Controllers\PlannerAppControllers\FlightEditorController::class,'selectDate']);
$app -> getRouter() -> post("/editFlight",[\App\Controllers\PlannerAppControllers\FlightEditorController::class,'loadFlight']);
$app -> getRouter() -> post("/selectAirplane",[\App\Controllers\PlannerAppControllers\FlightEditorController::class,'selectAirplane']);
$app -> getRouter() -> post("/selectTargetAirportTicketPriceAndConfirm",[\App\Controllers\PlannerAppControllers\FlightEditorController::class,'selectTargetAirportTicketPriceAndConfirm']);
$app -> getRouter() -> post("/cancelEditing",[\App\Controllers\PlannerAppControllers\FlightEditorController::class,'cancel']);
$app -> getRouter() -> post("/deleteFlight",[\App\Controllers\PlannerAppControllers\FlightEditorController::class,'deleteFlight']);
$app -> getRouter() -> post("/cancelConfirmation",[\App\Controllers\PlannerAppControllers\FlightEditorController::class,'cancelConfirmation']);
$app -> getRouter() -> post("/acceptConfirmation",[\App\Controllers\PlannerAppControllers\FlightEditorController::class,'acceptConfirmation']);

$app -> getRouter() -> post("/linkMember",[\App\Controllers\PlannerAppControllers\EditCrewController::class,'linkMember']);
$app -> getRouter() -> post("/unlinkMember",[\App\Controllers\PlannerAppControllers\EditCrewController::class,'unlinkMember']);
$app -> getRouter() -> post("/findAvailableMembers",[\App\Controllers\PlannerAppControllers\EditCrewController::class,'findAvailableMembers']);
$app -> getRouter() -> post("/loadCrewList",[\App\Controllers\PlannerAppControllers\EditCrewController::class,'loadCrewList']);


// styles:
$app -> getRouter() -> get("/style",[\App\Controllers\StyleController::class,'loginPage']);
$app -> getRouter() -> get("/commonStyle",[\App\Controllers\StyleController::class,'common']);
$app -> getRouter() -> get("/allFlightsStyles",[\App\Controllers\StyleController::class,'allFlights']);
$app -> getRouter() -> get("/jsCalendarsStyles",[\App\Controllers\StyleController::class,'JsCalendar']);
$app -> getRouter() -> get("/flightEditorStyles",[\App\Controllers\StyleController::class,'flightEditor']);
$app -> getRouter() -> get("/confirmationStyle",[\App\Controllers\StyleController::class,'confirmationPage']);
$app -> getRouter() -> get("/crewStyle",[\App\Controllers\StyleController::class,'crewPage']);
$app -> getRouter() -> get("/settlementsStyle",[\App\Controllers\StyleController::class,'settlementsPage']);
// scripts:
$app -> getRouter() -> get("/jsCalendarsScript",[\App\Controllers\ScriptController::class,'JsCalendar']);

//Passenger app:
$app -> getRouter() -> post("/getAvailableSeats",[BookingTicketsController::class, "getAvailableSeats"]);
$app -> getRouter() -> post("/getAllAirports",[BookingTicketsController::class, "getAllAirports"]);
$app -> getRouter() -> post("/getScheduleForRoute",[BookingTicketsController::class, "getScheduleForRoute"]);
$app -> getRouter() -> post("/getTargetAirports",[BookingTicketsController::class, "getTargetAirports"]);
$app -> getRouter() -> post("/insertTicket",[BookingTicketsController::class,'insertTicket']);
$app -> getRouter() -> post("/getPassengerIDIfExists",[PassengerLoginController::class,'getPassengerIDIfExists']);
$app -> getRouter() -> post("/loadCountries",[PassengerRegistrationController::class,'loadCountries']);
$app -> getRouter() -> post("/insertPassenger",[PassengerRegistrationController::class,'insertPassenger']);
$app -> getRouter() -> post("/getTicketsForPassengerID",[PassengersTicketsController::class,'getTicketsForPassengerID']);


$app -> run();