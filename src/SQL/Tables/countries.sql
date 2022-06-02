DROP PROCEDURE IF EXISTS resetTableCountries;
DELIMITER //
CREATE PROCEDURE resetTableCountries()
BEGIN
    DROP TABLE IF EXISTS Countries;
    CREATE TABLE Countries (
                               ID INT PRIMARY KEY AUTO_INCREMENT,
                               CountryName VARCHAR(50) NOT NULL
    );
END; //
DELIMITER ;


