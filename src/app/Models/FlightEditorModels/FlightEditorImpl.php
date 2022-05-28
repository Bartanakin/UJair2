<?php

namespace App\Models\FlightEditorModels;

use App\DataBaseConnection;
use App\Entities\Flight;
use App\Model;

class FlightEditorImpl extends Model implements \App\Interfaces\FlightEditorInterfaces\FlightEditor
{
    public function __construct(DataBaseConnection $dataBaseConnection)
    {
        parent::__construct( $dataBaseConnection);
    }
    private function findRouteID(int $startingAirportID, int $targetAirportID): int {
        $statement = $this -> getDBConnection() -> prepare(
            "SELECT Routes.ID AS RouteID
            FROM Routes 
            WHERE StartingAirportID = ? AND TargetAirportID = ? 
            ORDER BY Routes.Distance  
            LIMIT 1"
        );
        $statement -> execute([$startingAirportID,$targetAirportID]);
        return $statement -> fetch()['RouteID'];
    }

    public function insertFlight(Flight $flight): bool
    {
        $statement = $this -> getDBConnection() -> prepare("INSERT INTO Flights VALUES (NULL,?,?,?,?,FALSE)");

        try{
            $this -> getDBConnection() -> beginTransaction();
            $routeID = $this -> findRouteID($flight->getStartingAirport()->getID(),$flight->getTargetAirport()->getID());

            $statement -> execute([
                $routeID,
                $flight -> getDateOfDeparture() -> format(Model::$dateFormat),
                $flight -> getAirplane() -> getID(),
                $flight -> getPrice()
            ]);
            $this -> getDBConnection() -> commit();
        }catch( \PDOException $e ){
            $this -> getDBConnection() -> rollBack();
            throw new \PDOException($e -> getMessage());
        }
        return true;
    }

    public function editFlight(Flight $flight): bool
    {
        $statement = $this -> getDBConnection() -> prepare("
                        UPDATE Flights 
                        SET RouteID = ?, DateTimeOfDeparture = ?, AirPlaneID = ?, Price = ? 
                        WHERE ID = ?
                        ");

        try{
            $this -> getDBConnection() -> beginTransaction();
            $routeID = $this -> findRouteID($flight->getStartingAirport()->getID(),$flight->getTargetAirport()->getID());

            $statement -> execute([
                $routeID,
                $flight -> getDateOfDeparture() -> format(Model::$dateFormat),
                $flight -> getAirplane() -> getID(),
                $flight -> getPrice(),
                $flight -> getId()
            ]);
            $this -> getDBConnection() -> commit();
        }catch( \PDOException $e ){
            $this -> getDBConnection() -> rollBack();
            throw new \PDOException($e -> getMessage());
        }
        return true;
    }

    public function deleteFlight(Flight $flight): bool
    {
        $statement = $this -> getDBConnection() -> prepare("DELETE FROM Flights WHERE ID = ?");
        try{
            $this -> getDBConnection() -> beginTransaction();

            $statement -> execute([
                $flight -> getId()
            ]);

            $this -> getDBConnection() -> commit();
        }catch( \PDOException $e ){
            $this -> getDBConnection() -> rollBack();
            throw new \PDOException($e -> getMessage());
        }
        return true;
    }
}