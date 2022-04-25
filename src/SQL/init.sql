DROP DATABASE UJAIR2;
CREATE DATABASE UJAIR2;
SET GLOBAL log_bin_trust_function_creators = 1;


CREATE TABLE TestTable
(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    value1 INT NOT NULL
);
CREATE TABLE Pilots
(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(30) NOT NULL,
    Surname VARCHAR(40) NOT NULL,
    Salary DECIMAL(8,2) NOT NULL,
    Nationality VARCHAR(20),
    Degree VARCHAR(1)
);


INSERT INTO Pilots (FirstName,Surname,Salary,Nationality,Degree) VALUES
                                                                     ('Albert','Kowalski',12000,'Poland','C'),
                                                                     ('Jan','Płatwiński',7000,'Poland','F'),
                                                                     ('Joanna','Kowalczyk',10000,'Poland','C'),
                                                                     ('Edward','Orzechowski',8000,'Poland','F'),
                                                                     ('Krystian','Skorupiński',10000,'Poland','C'),
                                                                     ('John','Smith',12000,'UK','C'),
                                                                     ('Mathew','Collins',7000,'UK','F'),

                                                                     ('Stanisław','Iwanowski',12000,'Poland','C'),
                                                                     ('Jan','Pawlak',7000,'Poland','F'),
                                                                     ('Tadeusz','Serylak',10000,'Poland','C'),
                                                                     ('Tomasz','Sadowski',8000,'Poland','F'),

                                                                     ('Mateusz','Pospieszalski',12000,'Poland','C'),
                                                                     ('David','Becks',6000,'Ireland','F'),
                                                                     ('Peter','Sagan',10000,'Slovakia','C'),
                                                                     ('Michael','Nieve',10000,'Spain','F');

CREATE TABLE FlightAttendants
(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(30) NOT NULL,
    Surname VARCHAR(40) NOT NULL,
    Salary DECIMAL(8,2) NOT NULL,
    Nationality VARCHAR(20)
);
INSERT INTO FlightAttendants (FirstName, Surname, Salary, Nationality) VALUES
                                                                           ('Joanna','Kołaczkowska',6000,'Poland'),
                                                                           ('Aniela','Chmielewska',4000,'Poland'),
                                                                           ('Żaneta','Szewczyk',3000,'Poland'),
                                                                           ('Eleonora','Mróz',3000,'Poland'),
                                                                           ('Ewa','Zawadzka',6000,'Poland'),
                                                                           ('Kaja','Jankowska',6000,'Poland'),
                                                                           ('Zuzanna','Czerwińska',6000,'Poland'),
                                                                           ('Idalia','Mazurek',6000,'Poland'),
                                                                           ('Róża','Szulc',4000,'Poland'),
                                                                           ('Józefa','Makowska',3000,'Poland'),
                                                                           ('Daria','Kaczmarczyk',3000,'Poland'),
                                                                           ('Eliza','Szulc',3000,'Poland'),
                                                                           ('Czesława','Włodarczyk',6000,'Poland'),
                                                                           ('Marzanna','Górecka',4000,'Poland'),
                                                                           ('Honorata','Gajewska',4000,'Poland'),
                                                                           ('Florencja','Sadowska',6000,'Poland'),
                                                                           ('Izabela','Sikorska',5000,'Poland'),
                                                                           ('Jagoda','Kołodziej',3000,'Poland'),
                                                                           ('Alina','Szulc',3000,'Poland'),
                                                                           ('Małgorzata','Kubiak',5000,'Poland'),
                                                                           ('Natalia','Jasińska',5000,'Poland'),
                                                                           ('Ewa','Krajewska',5000,'Poland'),
                                                                           ('Magdalena','Sadowska',4000,'Poland'),
                                                                           ('Mirosława','Szewczyk',5000,'Poland'),
                                                                           ('Magdalena','Sokołowska',3000,'Poland'),
                                                                           ('Klementyna','Woźniak',3000,'Poland'),
                                                                           ('Małgorzata','Marciniak',3000,'Poland'),
                                                                           ('Barbara','Baranowska',6000,'Poland'),
                                                                           ('Florentyna','Rutkowska',5000,'Poland'),
                                                                           ('Amanda','Przybylska',5000,'Poland'),
                                                                           ('Anastazja','Chmielewska',6000,'Poland'),
                                                                           ('Magdalena','Mazur',5000,'Poland'),
                                                                           ('Grzegorz','Jaworski',4000,'Poland'),
                                                                           ('Kacper','Dąbrowski',6000,'Poland'),
                                                                           ('Marcin','Krawczyk',5000,'Poland'),
                                                                           ('Dorian','Baran',4000,'Poland'),
                                                                           ('Karol','Duda',6000,'Poland'),
                                                                           ('Przemysław','Tomaszewski',6000,'Poland'),
                                                                           ('Miłosz','Brzeziński',6000,'Poland'),
                                                                           ('Marek','Szewczyk',6000,'Poland');

CREATE TABLE AirplaneTypes
(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    TypeName VARCHAR(30) NOT NULL,
    Max_number_of_passangers INT NOT NULL,
    Max_number_of_stewards INT NOT NULL,
    Max_distance FLOAT NOT NULL,
    Avarage_speed_km_per_h FLOAT NOT NULL,
    Monthly_cost_of_leasing DECIMAL(12,2)

);

INSERT INTO AirplaneTypes VALUES
                              (NULL,'Boeing 737 MAX',178,8,12000,740,250000),
                              (NULL,'Airbus A320 neo',194,8,13000,750,330000),
                              (NULL,'Boeing 787-10 Dreamliner',336,14,25000,860,850000);


CREATE TABLE Airplanes
(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    AirplaneTypeID INT NOT NULL,
    Date_of_joining_fleet DATE NOT NULL,

    CONSTRAINT FK_AirplaneID_in_Airplanes FOREIGN KEY (AirplaneTypeID)
        REFERENCES AirplaneTypes(ID)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);

INSERT INTO Airplanes VALUES
                          (NULL,1,'2022-01-15'),
                          (NULL,1,'2022-01-15'),
                          (NULL,2,'2022-01-15'),
                          (NULL,2,'2022-01-15'),
                          (NULL,3,'2022-01-15');

CREATE TABLE Airports
(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Airport_name VARCHAR(30) NOT NULL,
    Price_of_reception DECIMAL(12,2) NOT NULL
);


INSERT INTO Airports VALUES
                         (NULL,'Heathrow', 5000),
                         (NULL,'Chopin', 3000),
                         (NULL,'Val-de-Marne', 4000);


CREATE TABLE Routes (
                        ID INT PRIMARY KEY AUTO_INCREMENT,
                        StartingAirportID INT NOT NULL,
                        TargetAirportID INT NOT NULL,
                        Distance FLOAT NOT NULL,

                        CONSTRAINT FK_StartingAirportID_in_Routes FOREIGN KEY (StartingAirportID)
                            REFERENCES Airports(ID)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE,

                        CONSTRAINT FK_TargetAirportID_in_Routes FOREIGN KEY (TargetAirportID)
                            REFERENCES Airports(ID)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
);

INSERT INTO Routes VALUES
                       (NULL,1,2,1000),
                       (NULL,2,1,1000),
                       (NULL,1,3,1200),
                       (NULL,2,3,1800),
                       (NULL,3,2,1800);

CREATE TABLE Flights (
                         ID INT PRIMARY KEY AUTO_INCREMENT,
                         RouteID INT NOT NULL,
                         DateTimeOfDeparture DATETIME NOT NULL,
                         AirPlaneID INT NOT NULL,
                         Price DECIMAL(12,2) NOT NULL, # TV
                             Canceled BOOLEAN DEFAULT FALSE,

                         CONSTRAINT FK_RouteID_in_Flights FOREIGN KEY (RouteID)
                             REFERENCES Routes(ID)
                             ON DELETE CASCADE
                             ON UPDATE CASCADE,

                         CONSTRAINT FK_AirPlaneID_in_Flights FOREIGN KEY (AirPlaneID)
                             REFERENCES Airplanes(ID)
                             ON DELETE CASCADE
                             ON UPDATE CASCADE

);

CREATE FUNCTION CalculateEstimatedArrivalTime( speed FLOAT, distance FLOAT, datetime_of_departure DATETIME )
    RETURNS DATETIME
    RETURN DATE_ADD(datetime_of_departure, INTERVAL 3600*distance/speed SECOND);




CREATE OR REPLACE VIEW FlightsData
AS
SELECT Flights.ID AS FlightID,
       Flights.DateTimeOfDeparture,
       Flights.RouteID,
       Flights.Price,
       StartingAirports.Airport_name AS StartingAirportName,
       TargetAirports.Airport_name AS TargetAirportName,
       Airplanes.ID AS AirplaneID,
       AirplaneTypes.TypeName,
       AirplaneTypes.Max_number_of_stewards,
       CalculateEstimatedArrivalTime(Avarage_speed_km_per_h,distance,DateTimeOfDeparture) AS EstimatedArrivalTime

FROM Flights
         JOIN
     Routes ON Routes.ID = Flights.RouteID
         JOIN
     Airplanes ON Flights.AirPlaneID = Airplanes.ID
         JOIN
     AirplaneTypes ON Airplanes.AirplaneTypeID = AirplaneTypes.ID
         JOIN
     Airports AS StartingAirports ON StartingAirports.ID = Routes.StartingAirportID
         JOIN
     Airports AS TargetAirports ON TargetAirports.ID = Routes.TargetAirportID;

DELIMITER //
CREATE PROCEDURE FindAllAirplanes(IN _when DATETIME )
BEGIN
SELECT A1.ID,( CASE
                   WHEN (
                       SELECT  MAX(DateTimeOfDeparture)
                       FROM FlightsData
                       WHERE AirPlaneID = A1.ID AND DateTimeOfDeparture <=_when
                 )
    >
             COALESCE((
                          SELECT  MAX(EstimatedArrivalTime)
                          FROM FlightsData
                          WHERE AirPlaneID = A1.ID AND EstimatedArrivalTime <=_when
                 ),'2000-01-01 00:00:00' )
    THEN 'In flight'
                   WHEN (
                            SELECT  MIN(DateTimeOfDeparture)
                            FROM FlightsData
                            WHERE AirPlaneID = A1.ID AND DateTimeOfDeparture >= _when
                        ) < DATE_ADD(_when,INTERVAL 1 HOUR)
                       THEN 'Preparing for flight'
                   WHEN (
                            SELECT MAX(EstimatedArrivalTime)
                            FROM FlightsData
                            WHERE AirPlaneID = A1.ID AND EstimatedArrivalTime <= _when
                        ) > DATE_ADD(_when,INTERVAL -30 MINUTE)
                       THEN 'After flight'
                   ELSE 'Free'
END) AS _Condition,
       COALESCE( # w ms sql ISNULL(SUM(Przychód),0)
               (SELECT F1.TargetAirportName FROM FlightsData AS F1
                WHERE A1.ID = F1.AirplaneID
                  AND F1.DateTimeOfDeparture =
                      (
                          SELECT MAX(F2.DateTimeOfDeparture)
                          FROM FlightsData AS F2
                          WHERE F2.DateTimeOfDeparture <= _when AND A1.ID = F2.AirplaneID
                      )),
               (SELECT A1.Airport_name
                FROM Airports AS A1
                WHERE A1.ID = ( SELECT MIN(A2.ID) FROM Airports AS A2 )
               )
           ) AS Current_airport
FROM Airplanes AS A1;
END // DELIMITER ;
#call FindAllAirplanes('2022-01-15 19:00:00');


DELIMITER //
CREATE PROCEDURE FindAllTargetAirports(IN starting_airport_name VARCHAR(30), IN max_distance FLOAT )
BEGIN
    IF max_distance = 0 THEN
SET max_distance = 1000000;
END IF;
SELECT Routes.ID,TargetAirports.Airport_name
FROM Routes
         JOIN
     Airports AS StartingAirports ON StartingAirports.ID = Routes.StartingAirportID
         JOIN
     Airports AS TargetAirports ON TargetAirports.ID = Routes.TargetAirportID

WHERE StartingAirports.Airport_name LIKE starting_airport_name
  AND Routes.Distance <= max_distance;
END // DELIMITER ;
#CALL FindAllTargetAirports('Y1',1500);

CREATE TABLE CrewList (
                          ID INT PRIMARY KEY AUTO_INCREMENT,
                          FlightID INT NOT NULL,
                          EmployeeID INT NOT NULL,
                          RoleID NVARCHAR(14) NOT NULL,

                          CONSTRAINT FK_FlightID_in_CrewList FOREIGN KEY (FlightID)
                              REFERENCES Flights(ID)
                              ON DELETE CASCADE
                              ON UPDATE CASCADE
);

CREATE TABLE Countries (
                           ID INT PRIMARY KEY AUTO_INCREMENT,
                           CountryName VARCHAR(50) NOT NULL
);

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


CREATE TABLE Passengers (
                            ID INT PRIMARY KEY AUTO_INCREMENT,
                            FirstName VARCHAR(30) NOT NULL,
                            Surname VARCHAR(40) NOT NULL,
                            CountryOfOriginID INT NOT NULL,
                            Login VARCHAR(20) UNIQUE NOT NULL,
                            Password VARCHAR(64) NOT NULL,

                            CONSTRAINT FK_CountryID_in_Passengers FOREIGN KEY (CountryOfOriginID)
                                REFERENCES Countries(ID)
                                ON DELETE CASCADE
                                ON UPDATE CASCADE
);


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
                             ON UPDATE CASCADE
);


CREATE OR REPLACE VIEW SoldTicketsForFlight
AS
SELECT T.FlightID AS FlightID, COUNT(*) AS SoldTickets FROM Tickets AS T
GROUP BY T.FlightID;

DELIMITER //
CREATE FUNCTION howManyTicketsAreAvailableOnFlight (
    flightID INT
)
    RETURNS INT
BEGIN
    DECLARE x, y INT DEFAULT 0;
    SET x = (SELECT ST.SoldTickets FROM SoldTicketsForFlight AS ST
             WHERE flightID = ST.FlightID);

    SET y = (SELECT AT.Max_number_of_passangers FROM SoldTicketsForFlight AS ST
                                                         JOIN Flights AS F ON ST.FlightID = F.ID
                                                         JOIN Airplanes AS A ON F.AirPlaneID = A.ID
                                                         JOIN AirplaneTypes AS AT ON A.AirplaneTypeID = AT.ID
             WHERE flightID = ST.FlightID);
RETURN (y - x);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE FindSuitablePilots(
    IN datetime_of_departure DATETIME,
    IN datetime_of_arrival DATETIME,
    IN degree VARCHAR(1)
) BEGIN
SELECT * FROM Pilots AS P1
WHERE P1.Degree >= degree
  AND
    NOT EXISTS (
            SELECT CL1.EmployeeID
            FROM CrewList AS CL1
                     JOIN
                 FlightsData AS F1 ON F1.FlightID = CL1.FlightID
            WHERE
                    CL1.EmployeeID = P1.ID
              AND
                    F1.DateTimeOfDeparture <= DATE_ADD(datetime_of_arrival, INTERVAL 1 HOUR)
              AND
                    F1.EstimatedArrivalTime >= DATE_ADD(datetime_of_departure, INTERVAL -1 HOUR)
        );

END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE FindSuitableStewards(
    IN datetime_of_departure DATETIME,
    IN datetime_of_arrival DATETIME
) BEGIN
SELECT * FROM FlightAttendants AS S1
WHERE NOT EXISTS (
        SELECT CL1.EmployeeID
        FROM CrewList AS CL1
                 JOIN
             FlightsData AS F1 ON F1.FlightID = CL1.FlightID
        WHERE
                CL1.EmployeeID = S1.ID
          AND
                F1.DateTimeOfDeparture <= DATE_ADD(datetime_of_arrival, INTERVAL 1 HOUR)
          AND
                F1.EstimatedArrivalTime >= DATE_ADD(datetime_of_departure, INTERVAL -1 HOUR)
    );

END //
DELIMITER ;