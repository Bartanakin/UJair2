DROP DATABASE UJAIR2;
CREATE DATABASE UJAIR2;
SET GLOBAL log_bin_trust_function_creators = 1;

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


INSERT INTO Employees (FirstName,Surname,Salary,Nationality,Degree) VALUES
        ('Albert','Kowalski',12000,13,'C'),
        ('Jan','Płatwiński',7000,13,'F'),
        ('Joanna','Kowalczyk',10000,13,'C'),
        ('Edward','Orzechowski',8000,13,'F'),
        ('Krystian','Skorupiński',10000,13,'C'),
        ('John','Smith',12000,3,'C'),
        ('Mathew','Collins',7000,3,'F'),

        ('Stanisław','Iwanowski',12000,13,'C'),
        ('Jan','Pawlak',7000,13,'F'),
        ('Tadeusz','Serylak',10000,13,'C'),
        ('Tomasz','Sadowski',8000,13,'F'),

        ('Mateusz','Pospieszalski',12000,13,'C'),
        ('David','Becks',6000,10,'F'),
        ('Peter','Sagan',10000,12,'C'),
        ('Michael','Nieve',10000,4,'F');

INSERT INTO Employees (FirstName, Surname, Salary, Nationality, Degree) VALUES
           ('Joanna','Kołaczkowska',6000,13, 'S'),
           ('Aniela','Chmielewska',4000,13, 'S'),
           ('Żaneta','Szewczyk',3000,13, 'S'),
           ('Eleonora','Mróz',3000,13, 'S'),
           ('Ewa','Zawadzka',6000,13, 'S'),
           ('Kaja','Jankowska',6000,13, 'S'),
           ('Zuzanna','Czerwińska',6000,13, 'S'),
           ('Idalia','Mazurek',6000,13, 'S'),
           ('Róża','Szulc',4000,13, 'S'),
           ('Józefa','Makowska',3000,13, 'S'),
           ('Daria','Kaczmarczyk',3000,13, 'S'),
           ('Eliza','Szulc',3000,13, 'S'),
           ('Czesława','Włodarczyk',6000,13, 'S'),
           ('Marzanna','Górecka',4000,13, 'S'),
           ('Honorata','Gajewska',4000,13, 'S'),
           ('Florencja','Sadowska',6000,13, 'S'),
           ('Izabela','Sikorska',5000,13, 'S'),
           ('Jagoda','Kołodziej',3000,13, 'S'),
           ('Alina','Szulc',3000,13, 'S'),
           ('Małgorzata','Kubiak',5000,13, 'S'),
           ('Natalia','Jasińska',5000,13, 'S'),
           ('Ewa','Krajewska',5000,13, 'S'),
           ('Magdalena','Sadowska',4000,13, 'S'),
           ('Mirosława','Szewczyk',5000,13, 'S'),
           ('Magdalena','Sokołowska',3000,13, 'S'),
           ('Klementyna','Woźniak',3000,13, 'S'),
           ('Małgorzata','Marciniak',3000,13, 'S'),
           ('Barbara','Baranowska',6000,13, 'S'),
           ('Florentyna','Rutkowska',5000,13, 'S'),
           ('Amanda','Przybylska',5000,13, 'S'),
           ('Anastazja','Chmielewska',6000,13, 'S'),
           ('Magdalena','Mazur',5000,13, 'S'),
           ('Grzegorz','Jaworski',4000,13, 'S'),
           ('Kacper','Dąbrowski',6000,13, 'S'),
           ('Marcin','Krawczyk',5000,13, 'S'),
           ('Dorian','Baran',4000,13, 'S'),
           ('Karol','Duda',6000,13, 'S'),
           ('Przemysław','Tomaszewski',6000,13, 'S'),
           ('Miłosz','Brzeziński',6000,13, 'S'),
           ('Marek','Szewczyk',6000,13, 'S');

INSERT INTO AirplaneTypes VALUES
                              (NULL,'Boeing 737 MAX',178,8,12000,740,250000),
                              (NULL,'Airbus A320 neo',194,8,13000,750,330000),
                              (NULL,'Boeing 787-10 Dreamliner',336,14,25000,860,850000);

INSERT INTO Airplanes VALUES
                          (NULL,1,'2020-01-15'),
                          (NULL,1,'2021-06-14'),
                          (NULL,2,'2018-10-01'),
                          (NULL,2,'2022-01-15'),
                          (NULL,3,'2010-05-23'),
                          (NULL,3,'2019-11-21'),
                          (NULL,3,'2016-07-24');


INSERT INTO Airports VALUES
                         (NULL,'Heathrow', 5000, 15),
                         (NULL,'Chopin', 3000, 13),
                         (NULL,'Val-de-Marne', 4000, 16),
                         (NULL,'Hartsfield–Jackson Atlanta', 6000, 17),
                         (NULL,'Mexico City', 5500, 19),
                         (NULL,'Charles de Gaulle', 4600, 16),
                         (NULL,'Frankfurt', 3900, 20)
;


INSERT INTO Routes VALUES
                       (NULL,1,2,1000),
                       (NULL,2,1,1000),
                       (NULL,1,3,1200),
                       (NULL,2,3,1800),
                       (NULL,3,2,1800);