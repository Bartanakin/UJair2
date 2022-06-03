DROP PROCEDURE IF EXISTS findCrewForFlightSetUp;
CREATE PROCEDURE findCrewForFlightSetUp()
BEGIN
    CALL resetTableCrewList();
    CALL resetTableEmployees();
    CALL resetTableAirports();
    CALL resetTableRoutes();
    CALL resetTableFlights();
    CALL resetTableAirplanes();
    CALL resetTableAirplaneTypes();

    INSERT INTO AirplaneTypes
    VALUES (1, 'Boeing 737 MAX', 200, 3, 30000, 800, 100000);

    INSERT INTO Airplanes
    VALUES (1, 1, '2020-06-06 00:00:00'),
           (2, 1, '2020-06-06 00:00:00');

    INSERT INTO Airports
    VALUES (1, 'X', 1000, 1),
           (2, 'Y', 1000, 2),
           (3, 'Z', 1000, 3);
    INSERT INTO Routes
    VALUES (1, 1, 2, 1000),
           (2, 1, 3, 1000),
           (3, 2, 3, 1000),
           (4, 3, 1, 1000);
    INSERT INTO Flights
    VALUES (1, 1, '2022-06-06 08:00:00', 1, 100, false), # 1 'X' 'Y'
           (2, 3, '2022-06-06 14:00:00', 1, 100, false), # 2 'Y' 'Z'
           (3, 4, '2022-06-06 20:00:00', 1, 100, false), # 1 'X' 'Y'
           (4, 3, '2022-06-06 14:00:00', 2, 100, true), # 2 'Y' 'Z'
           (5, 4, '2022-06-06 20:00:00', 2, 100, true), # 3 'Z' 'X'
           (6, 4, '2022-06-06 20:00:00', 2, 100, true); # 3 'Z' 'X'
    INSERT INTO Employees (ID,FirstName,Surname,Salary,Nationality,Degree) VALUES
          (1,'Albert','Kowalski',12000,1,'C'),
          (2,'Jan','Płatwiński',7000,1,'F'),
          (3,'Joanna','Kowalczyk',10000,1,'C'),
          (4,'Edward','Orzechowski',8000,1,'F'),
          (5,'Joanna','Kołaczkowska',6000,1,'S'),
          (6,'Aniela','Chmielewska',4000,1,'S'),
          (7,'Żaneta','Szewczyk',3000,1,'S'),
          (8,'Marzanna','Górecka',4000,1,'S');


        INSERT INTO CrewList VALUES
        -- Flight 1
        (NULL,1,1,'F'),
        (NULL,1,3,'C'),
        (NULL,1,5,'S'),
        (NULL,1,6,'S'),
         -- Flight 2
        (NULL,2,2,'F'),
        (NULL,2,3,'C'),
        -- Flight 3
        (NULL,3,2,'F'),
        (NULL,3,3,'C'),
        (NULL,3,5,'S'),
        (NULL,3,6,'S'),
        (NULL,3,7,'S'),
        -- Flight 4 cancelled
        (NULL,4,2,'F'),
        (NULL,4,3,'C'),
        (NULL,4,5,'S'),
        (NULL,4,6,'S');
end;

