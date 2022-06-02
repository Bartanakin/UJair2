DROP PROCEDURE IF EXISTS findCrewListOfFlight;
DELIMITER //
CREATE PROCEDURE findCrewListOfFlight(IN input_flightID INT)
BEGIN

    SELECT CrewList.RoleID AS RoleID,
           Employees.ID AS EmployeeID,
           Employees.FirstName AS FirstName,
           Employees.Surname AS Surname,
           Employees.Degree AS Degree
    FROM CrewList
             JOIN Employees ON CrewList.EmployeeID = Employees.ID
    WHERE FlightID = input_flightID;

end // DELIMITER ;