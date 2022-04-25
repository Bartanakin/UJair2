
DELIMITER //
CREATE  PROCEDURE getReservedSeatsForFlightID(IN FlightID INT)
BEGIN
    SELECT RSFF.NumberOfSeat FROM ReservedSeatsForFlight AS RSFF WHERE RSFF.FlightID = FlightID;
END //
DELIMITER ;

