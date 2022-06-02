DROP PROCEDURE If EXISTS resetTableCrewList;
DELIMITER //
CREATE PROCEDURE resetTableCrewList()
BEGIN
    DROP TABLE IF EXISTS CrewList;
    CREATE TABLE CrewList (
                              ID INT PRIMARY KEY AUTO_INCREMENT,
                              FlightID INT NOT NULL,
                              EmployeeID INT NOT NULL,
                              RoleID NVARCHAR(14) NOT NULL

#       CONSTRAINT FK_FlightID_in_CrewList FOREIGN KEY (FlightID)
#           REFERENCES Flights(ID)
#           ON DELETE CASCADE
#           ON UPDATE CASCADE
    );
END //
DELIMITER ;
