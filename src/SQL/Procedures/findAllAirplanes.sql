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
           COALESCE( 
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