DROP TABLE Pilots;
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