CREATE PROCEDURE findAllFlightsSetUp()
BEGIN

    CALL resetTableFlights();
    CALL resetTableRoutes();
    CALL resetTableAirports();
    CALL resetTableAirplanes();
    CALL resetTableAirplaneTypes();

    INSERT INTO AirplaneTypes
    VALUES (1, 'Boeing 737 MAX', 200, 10, 30000, 800, 100000);
    INSERT INTO Airplanes
    VALUES (1, 1, '2020-06-06 00:00:00'),
           (2, 1, '2020-06-06 00:00:00');
    INSERT INTO Airports
    VALUES (1, 'X', 1000),
           (2, 'Y', 1000),
           (3, 'Z', 1000);
    INSERT INTO Routes
    VALUES (1, 1, 2, 1000),
           (2, 1, 3, 1000),
           (3, 2, 3, 1000),
           (4, 3, 1, 1000);
    INSERT INTO Flights
    VALUES (1, 1, '2022-06-06 08:00:00', 1, 100, false), # 1 'X' 'Y'
           (2, 3, '2022-06-06 14:00:00', 1, 100, false), # 2 'Y' 'Z'
           (3, 1, '2022-06-06 08:00:00', 2, 100, false), # 1 'X' 'Y'
           (4, 3, '2022-06-06 14:00:00', 2, 100, false), # 2 'Y' 'Z'
           (5, 4, '2022-06-06 20:00:00', 2, 100, false), # 3 'Z' 'X'
           (6, 4, '2022-06-06 20:00:00', 2, 100, true); # 3 'Z' 'X'
end;

