CREATE PROCEDURE resetTableAirplanes()
BEGIN
    DROP TABLE IF EXISTS Airplanes;
    CREATE TABLE Airplanes
    (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        AirplaneTypeID INT NOT NULL,
        Date_of_joining_fleet DATE NOT NULL

    #     CONSTRAINT FK_AirplaneID_in_Airplanes FOREIGN KEY (AirplaneTypeID)
    #         REFERENCES AirplaneTypes(ID)
    #         ON DELETE NO ACTION
    #         ON UPDATE CASCADE
    );
END;

# INSERT INTO Airplanes VALUES
#       (NULL,1,'2022-01-15'),
#       (NULL,1,'2022-01-15'),
#       (NULL,2,'2022-01-15'),
#       (NULL,2,'2022-01-15'),
#       (NULL,3,'2022-01-15');