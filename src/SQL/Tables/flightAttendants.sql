CREATE PROCEDURE resetTableFlightAttendants()
BEGIN
DROP TABLE IF EXISTS FlightAttendants;
CREATE TABLE FlightAttendants
(
    ID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(30) NOT NULL,
    Surname VARCHAR(40) NOT NULL,
    Salary DECIMAL(8,2) NOT NULL,
    Nationality VARCHAR(20)
);
END
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