DROP PROCEDURE IF EXISTS  resetTableRoutes;
DELIMITER //
CREATE PROCEDURE resetTableRoutes()
BEGIN
DROP TABLE IF EXISTS Routes;
CREATE TABLE Routes (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    StartingAirportID INT NOT NULL,
    TargetAirportID INT NOT NULL,
    Distance FLOAT NOT NULL

#     CONSTRAINT FK_StartingAirportID_in_Routes FOREIGN KEY (StartingAirportID)
#         REFERENCES Airports(ID)
#         ON DELETE CASCADE
#         ON UPDATE CASCADE,

#     CONSTRAINT FK_TargetAirportID_in_Routes FOREIGN KEY (TargetAirportID)
#         REFERENCES Airports(ID)
#         ON DELETE CASCADE
#         ON UPDATE CASCADE
);
END //
#
# INSERT INTO Routes VALUES
#    (NULL,1,2,1000),
#    (NULL,2,1,1000),
#    (NULL,1,3,1200),
#    (NULL,2,3,1800),
#    (NULL,3,2,1800);
DELIMITER ;