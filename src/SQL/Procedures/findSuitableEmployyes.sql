DROP PROCEDURE IF EXISTS FindSuitableEmployees;
CREATE PROCEDURE FindSuitableEmployees(
    IN degree VARCHAR(1)
) BEGIN
    SELECT
        ID,
        FirstName,
        Surname,
        P1.Degree as empDegree
    FROM Employees AS P1
    WHERE P1.Degree IN ( 'C', 'F') AND degree like 'F'
       OR
    P1.Degree LIKE 'C' AND degree LIKE 'C'
        OR
    P1.Degree LIKE 'S' AND degree LIKE 'S';
END;
