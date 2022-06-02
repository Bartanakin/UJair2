
CREATE TABLE Planners
(
    ID int auto_increment PRIMARY KEY,
    Username NVARCHAR(20),
    PasswordHash NVARCHAR(60)
);

INSERT INTO Planners VALUES
( NULL, 'planner1','$2y$10$7y6Q38rb2w.kLDjswxa3BuRI2yXheCYnfxh0njX./4iP2KTpCL9vW');