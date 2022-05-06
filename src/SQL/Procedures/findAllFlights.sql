
CREATE PROCEDURE findAllFlights( )
BEGIN
    SELECT Flights.ID AS FlightID,
           Flights.DateTimeOfDeparture AS DateTimeOfDeparture,
           SA.Airport_name AS StartingAirportName,
           TA.Airport_name AS TargetAirportName,
           A.ID AS AirplaneID,
           AType.TypeName AS AirplaneTypeName
            FROM Flights
    JOIN Routes R on Flights.RouteID = R.ID
    JOIN Airports SA ON R.StartingAirportID = SA.ID
    JOIN Airports TA ON R.TargetAirportID = TA.ID
    JOIN Airplanes A on Flights.AirPlaneID = A.ID
    JOIN AirplaneTypes AType ON A.AirplaneTypeID = AType.ID
    WHERE Flights.Canceled = false;

END