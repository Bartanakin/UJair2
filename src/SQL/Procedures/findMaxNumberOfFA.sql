DROP PROCEDURE IF EXISTS findMaxNumberOfFA;
DELIMITER //
CREATE PROCEDURE findMaxNumberOfFA(in flightID int)
BEGIN

    SELECT AirplaneTypes.Max_number_of_stewards as maxNumberOfFA
    FROM Flights
             JOIN Airplanes ON Airplanes.ID = Flights.AirPlaneID
             JOIN AirplaneTypes ON AirplaneTypes.ID = Airplanes.AirplaneTypeID
    WHERE Flights.ID = flightID
    LIMIT 1;
end; //
DELIMITER ;