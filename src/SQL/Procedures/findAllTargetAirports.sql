DELIMITER //
CREATE PROCEDURE FindAllTargetAirports(IN starting_airport_name VARCHAR(30), IN max_distance FLOAT )
BEGIN
    IF max_distance = 0 THEN
        SET max_distance = 1000000;
    END IF;
    SELECT Routes.ID,TargetAirports.Airport_name
    FROM Routes
             JOIN
         Airports AS StartingAirports ON StartingAirports.ID = Routes.StartingAirportID
             JOIN
         Airports AS TargetAirports ON TargetAirports.ID = Routes.TargetAirportID

    WHERE StartingAirports.Airport_name LIKE starting_airport_name
      AND Routes.Distance <= max_distance;
END // DELIMITER ;