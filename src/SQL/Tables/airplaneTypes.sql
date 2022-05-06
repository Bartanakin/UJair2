CREATE PROCEDURE resetTableAirplaneTypes()
BEGIN
DROP TABLE IF EXISTS AirplaneTypes;
CREATE TABLE AirplaneTypes
(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    TypeName VARCHAR(30) NOT NULL,
    Max_number_of_passengers INT NOT NULL,
    Max_number_of_stewards INT NOT NULL,
    Max_distance FLOAT NOT NULL,
    Average_speed_km_per_h FLOAT NOT NULL,
    Monthly_cost_of_leasing DECIMAL(12,2)

);
END;
# INSERT INTO AirplaneTypes VALUES
#       (NULL,'Boeing 737 MAX',178,8,12000,740,250000),
#       (NULL,'Airbus A320 neo',194,8,13000,750,330000),
#       (NULL,'Boeing 787-10 Dreamliner',336,14,25000,860,850000);

