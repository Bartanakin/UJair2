
CREATE OR REPLACE VIEW ReservedSeatsForFlight
AS
SELECT F.ID, T.NumberOfSeat, AT.Max_number_of_passengers FROM Tickets AS T
                                      JOIN Flights AS F ON F.ID = T.FlightID
                                      JOIN Airplanes AS A ON F.AirPlaneID = A.ID
                                      JOIN AirplaneTypes AS AT ON A.AirplaneTypeID = AT.ID; 
