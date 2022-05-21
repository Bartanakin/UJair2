DROP PROCEDURE IF EXISTS findTargetAirportsSetUp;
CREATE PROCEDURE findTargetAirportsSetUp()
BEGIN

    CALL resetTableAirports();
    CALL resetTableRoutes();

    INSERT INTO Airports
    VALUES (1, 'X', 1000),
           (2, 'Y', 1000),
           (3, 'Z', 1000);
    INSERT INTO Routes
    VALUES (1, 1, 2, 1000),
           (2, 1, 3, 2000),
           (3, 2, 3, 1000),
           (4, 2, 1, 2000);
end;