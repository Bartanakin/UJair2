CREATE PROCEDURE resetTablePassengers()
BEGIN
DROP TABLE IF EXISTS Passengers;
CREATE TABLE Passengers (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(30) NOT NULL,
    Surname VARCHAR(40) NOT NULL,
    CountryOfOriginID INT NOT NULL,
    Login VARCHAR(20) UNIQUE NOT NULL,
    Password VARCHAR(64) NOT NULL

#     CONSTRAINT FK_CountryID_in_Passengers FOREIGN KEY (CountryOfOriginID)
#         REFERENCES Countries(ID)
#         ON DELETE CASCADE
#         ON UPDATE CASCADE
);
END