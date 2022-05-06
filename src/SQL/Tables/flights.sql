CREATE PROCEDURE resetTableFlights()
BEGIN
DROP TABLE IF EXISTS Flights;
CREATE TABLE Flights (
     ID INT PRIMARY KEY AUTO_INCREMENT,
     RouteID INT NOT NULL,
     DateTimeOfDeparture DATETIME NOT NULL,
     AirPlaneID INT NOT NULL,
     Price DECIMAL(12,2) NOT NULL,
     Canceled BOOLEAN DEFAULT FALSE

#      CONSTRAINT FK_RouteID_in_Flights FOREIGN KEY (RouteID)
#          REFERENCES Routes(ID)
#          ON DELETE CASCADE
#          ON UPDATE CASCADE,
#
#      CONSTRAINT FK_AirPlaneID_in_Flights FOREIGN KEY (AirPlaneID)
#          REFERENCES Airplanes(ID)
#          ON DELETE CASCADE
#          ON UPDATE CASCADE

);
END