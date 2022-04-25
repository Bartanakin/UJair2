CREATE OR REPLACE VIEW SoldTicketsForFlight
AS
SELECT T.FlightID AS FlightID, COUNT(*) AS SoldTickets FROM Tickets AS T
GROUP BY T.FlightID;