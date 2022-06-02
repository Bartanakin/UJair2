DROP PROCEDURE IF EXISTS resetTableAirports;
DELIMITER //
CREATE PROCEDURE resetTableAirports()
BEGIN
    DROP TABLE IF EXISTS Airports;
    CREATE TABLE Airports
    (
        ID INT PRIMARY KEY AUTO_INCREMENT,
        Airport_name VARCHAR(30) NOT NULL,
        Price_of_reception DECIMAL(12,2) NOT NULL,
        CountryID INT NOT NULL
    );
END; //
DELIMITER ;

# INSERT INTO Airports VALUES
#      (NULL,'Heathrow', 5000),
#      (NULL,'Chopin', 3000),
#      (NULL,'Val-de-Marne', 4000);
#
