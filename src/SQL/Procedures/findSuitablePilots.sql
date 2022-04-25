DELIMITER //
CREATE PROCEDURE FindSuitablePilots(
    IN datetime_of_departure DATETIME,
    IN datetime_of_arrival DATETIME,
    IN degree VARCHAR(1)
) BEGIN
    SELECT * FROM Pilots AS P1
    WHERE P1.Degree >= degree
      AND
        NOT EXISTS (
                SELECT CL1.EmployeeID
                FROM CrewList AS CL1
                         JOIN
                     FlightsData AS F1 ON F1.FlightID = CL1.FlightID
                WHERE
                        CL1.EmployeeID = P1.ID
                  AND
                        F1.DateTimeOfDeparture <= DATE_ADD(datetime_of_arrival, INTERVAL 1 HOUR)
                  AND
                        F1.EstimatedArrivalTime >= DATE_ADD(datetime_of_departure, INTERVAL -1 HOUR)
            );

END //
DELIMITER ;