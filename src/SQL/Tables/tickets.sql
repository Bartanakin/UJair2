DROP TABLE Tickets;
CREATE TABLE Tickets (
     ID INT PRIMARY KEY AUTO_INCREMENT,
     FlightID INT NOT NULL,
     NumberOfSeat INT NOT NULL,
     PassengerID INT NOT NULL,

     CONSTRAINT FK_FlightID_in_Tickets FOREIGN KEY (FlightID)
         REFERENCES Flights(ID)
         ON DELETE NO ACTION
         ON UPDATE CASCADE,

     CONSTRAINT FK_PassengerID_in_Tickets FOREIGN KEY (PassengerID)
         REFERENCES Passengers(ID)
         ON DELETE CASCADE
         ON UPDATE CASCADE,

     CONSTRAINT uc UNIQUE (FlightID,NumberOfSeat)
);