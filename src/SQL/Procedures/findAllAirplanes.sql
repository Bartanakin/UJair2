DROP PROCEDURE  IF EXISTS  FindAllAirplanes;
DELIMITER //
CREATE PROCEDURE FindAllAirplanes(IN _when DATETIME )
BEGIN
    SELECT A1.ID as AirplaneID,ATypes.TypeName as AirplaneTypeName,( CASE
                       WHEN (
                                SELECT  MAX(F.DateTimeOfDeparture)
                                FROM Flights AS F
                                WHERE F.AirPlaneID = A1.ID AND F.DateTimeOfDeparture <=_when AND Canceled = FALSE
                            )
                           >
                            COALESCE((
                                         SELECT MAX(EstimatedArrivalTime)
                                         FROM FlightsData
                                         WHERE AirPlaneID = A1.ID AND EstimatedArrivalTime <=_when
                                     ),'2000-01-01 00:00:00' )
                           THEN 'In flight'
                       WHEN (
                                SELECT  MIN(DateTimeOfDeparture)
                                FROM FlightsData
                                WHERE AirPlaneID = A1.ID AND DateTimeOfDeparture >= _when
                            ) < DATE_ADD(_when,INTERVAL 30 MINUTE)
                           THEN 'Preparing for flight'
                       WHEN (
                                SELECT MAX(EstimatedArrivalTime)
                                FROM FlightsData
                                WHERE AirPlaneID = A1.ID AND EstimatedArrivalTime <= _when
                            ) > DATE_ADD(_when,INTERVAL -30 MINUTE)
                           THEN 'After flight'
                       ELSE 'Free'
        END) AS _Condition,
           COALESCE(
                   (SELECT F1.TargetAirportID FROM FlightsData AS F1
                    WHERE A1.ID = F1.AirplaneID
                      AND F1.DateTimeOfDeparture =
                          (
                              SELECT MAX(F2.DateTimeOfDeparture)
                              FROM FlightsData AS F2
                              WHERE F2.DateTimeOfDeparture <= _when AND A1.ID = F2.AirplaneID
                          )),
                   (SELECT MIN(Ap.ID) FROM Airports AS Ap )
               ) AS StartingAirportID,
               COALESCE(
                   (SELECT F1.TargetAirportName FROM FlightsData AS F1
                    WHERE A1.ID = F1.AirplaneID
                      AND F1.DateTimeOfDeparture =
                          (
                              SELECT MAX(F2.DateTimeOfDeparture)
                              FROM FlightsData AS F2
                              WHERE F2.DateTimeOfDeparture <= _when AND A1.ID = F2.AirplaneID
                          ) LIMIT 1),
                   (SELECT Ap.Airport_name
                    FROM Airports AS Ap
                    WHERE Ap.ID = ( SELECT MIN(A2.ID) FROM Airports AS A2 )
                    LIMIT 1
                   )
               ) AS StartingAirportName
    FROM Airplanes AS A1 JOIN AirplaneTypes AS ATypes ON A1.AirplaneTypeID = ATypes.ID;
END // DELIMITER ;
