<?php

namespace App\Models\SettlementModels;

use App\DataBaseConnection;
use App\Entities\SettlementClasses\AirplaneLeasingPayment;
use App\Entities\SettlementClasses\SalaryExpense;
use App\Entities\SettlementClasses\FlightPayment;
use App\Interfaces\Currents;
use App\Model;

class SettlementFinderImpl extends Model implements \App\Interfaces\SettlementInterfaces\SettlementFinder
{

    public function __construct(DataBaseConnection $db, protected Currents $currents)
    {
        parent::__construct($db);
    }

    private function allSalaryMonths(\DateTime $date,float $salary, string $class): array{
        $payments = [];
        $now = $this -> currents -> now();
        $date = $date -> add(\DateInterval::createFromDateString("1 month"));
        while( $date < $now ){
            $payments[] = call_user_func_array([$class,'createForAllSalaryMonths'],[clone $date,$salary]);
            $date = $date -> add(\DateInterval::createFromDateString("1 month"));
        }
        return $payments;
    }

    public function findSalaries(): array
    {
        $payments = [];
        $statement = $this -> getDBConnection() -> prepare('
            SELECT Salary, DateOfEmployment
            FROM Employees
        ');
        $statement -> execute();

        while( $row = $statement -> fetch() ){
            $payments = array_merge(
                $payments,
                $this -> allSalaryMonths(
                    \DateTime::createFromFormat(Model::$dateFormat,$row['DateOfEmployment']),
                    -$row['Salary'],
                    SalaryExpense::class
                )
            );
        }
        return $payments;
    }

    public function findAirplanesLeasing(): array
    {
        $statement = $this -> getDBConnection() -> prepare('
            SELECT Airplanes.Date_of_joining_fleet AS Date, AirplaneTypes.Monthly_cost_of_leasing AS Cost
            FROM Airplanes 
                JOIN AirplaneTypes ON Airplanes.AirplaneTypeID = AirplaneTypes.ID
        ');

        $statement -> execute();
        $payments = [];

        while( $row = $statement -> fetch() ){
            $payments = array_merge(
                $payments,
                $this -> allSalaryMonths(
                    \DateTime::createFromFormat(Model::$dateFormat,$row['Date']),
                        -$row['Cost'],
                        AirplaneLeasingPayment::class
                    )
            );
        }

        return $payments;
    }

    public function ticketsPayment(): array
    {
        $statement = $this -> getDBConnection() -> prepare('
            SELECT Count(*)*Flights.Price - Airports.Price_of_reception as TotalPayment, 
                   DateTimeOfDeparture AS Date
            FROM Flights
                JOIN Tickets ON Tickets.FlightID = Flights.ID
                JOIN Routes ON Flights.RouteID = Routes.ID
                JOIN Airports ON Routes.TargetAirportID = Airports.ID
            GROUP BY Flights.ID, Flights.Price, DateTimeOfDeparture, Airports.Price_of_reception
        ');

        $statement -> execute();
        $payments = [];

        while( $row = $statement -> fetch() ){
            $payments[] = FlightPayment::createForAllSalaryMonths(
                \DateTime::createFromFormat(Model::$dateFormat,$row['Date']),
                $row['TotalPayment']
            );
        }
        return $payments;
    }

}