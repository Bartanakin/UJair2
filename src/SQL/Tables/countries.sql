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

INSERT INTO Countries VALUES
  (NULL, 'Morocco'),
  (NULL, 'Afghanistan'),
  (NULL, 'Finland'),
  (NULL, 'Latvia'),
  (NULL, 'Romania'),
  (NULL, 'Uzbekistan'),
  (NULL, 'Monaco'),
  (NULL, 'Greece'),
  (NULL, 'Brazil'),
  (NULL, 'Australia'),
  (NULL, 'Hungary'),
  (NULL, 'Serbia'),
  (NULL, 'Poland'),
  (NULL, 'Italy');
