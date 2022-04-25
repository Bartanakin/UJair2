DELIMITER //
CREATE FUNCTION howManyTicketsAreAvailableOnFlight (
    flightID INT
)
    RETURNS INT
BEGIN
    DECLARE x, y INT DEFAULT 0;
    SET x = (SELECT ST.SoldTickets FROM SoldTicketsForFlight AS ST
             WHERE flightID = ST.FlightID);

    SET y = (SELECT AT.Max_number_of_passangers FROM SoldTicketsForFlight AS ST
                                                         JOIN Flights AS F ON ST.FlightID = F.ID
                                                         JOIN Airplanes AS A ON F.AirPlaneID = A.ID
                                                         JOIN AirplaneTypes AS AT ON A.AirplaneTypeID = AT.ID
             WHERE flightID = ST.FlightID);
    RETURN (y - x);
END //
DELIMITER ;