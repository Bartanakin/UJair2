
CREATE OR REPLACE VIEW FlightsData
AS
SELECT Flights.ID AS FlightID,
       Flights.DateTimeOfDeparture,
       Flights.RouteID,
       Flights.Price,
       StartingAirports.Airport_name AS StartingAirportName,
       TargetAirports.Airport_name AS TargetAirportName,
       Airplanes.ID AS AirplaneID,
       AirplaneTypes.TypeName,
       AirplaneTypes.Max_number_of_stewards,
       CalculateEstimatedArrivalTime(Avarage_speed_km_per_h,distance,DateTimeOfDeparture) AS EstimatedArrivalTime

FROM Flights
         JOIN
     Routes ON Routes.ID = Flights.RouteID
         JOIN
     Airplanes ON Flights.AirPlaneID = Airplanes.ID
         JOIN
     AirplaneTypes ON Airplanes.AirplaneTypeID = AirplaneTypes.ID
         JOIN
     Airports AS StartingAirports ON StartingAirports.ID = Routes.StartingAirportID
         JOIN
     Airports AS TargetAirports ON TargetAirports.ID = Routes.TargetAirportID;
