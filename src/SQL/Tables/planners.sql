CREATE TABLE Planners
(
    ID int auto_increment,
    Username NVARCHAR(20),
    PasswordHash NVARCHAR(60)
);

INSERT INTO Planners VALUES
( NULL, 'planner1','$2y$10$z4UyLSm4VrUQT8Hdj4Bgjuo3wmcIAzd7w3rqvrN2ITtcbbx1Avv1q');